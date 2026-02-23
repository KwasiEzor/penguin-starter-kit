<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Events\NewPostPublished;
use App\Livewire\Concerns\HasToast;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Livewire component for editing an existing blog post.
 *
 * Provides a form pre-populated with the post's current data, allowing the author
 * to update the title, body, slug, excerpt, SEO metadata, tags, categories, and
 * featured image. Handles authorization, slug auto-update logic, tag and category
 * syncing, and sends notifications when a draft is newly published.
 */
#[Layout('components.layouts.app')]
final class Edit extends Component
{
    use HasToast;
    use WithFileUploads;

    public Post $post;

    public string $title = '';

    public string $body = '';

    public string $status = 'draft';

    public string $slug = '';

    public string $excerpt = '';

    public string $meta_title = '';

    public string $meta_description = '';

    public string $tags_input = '';

    /** @var array<int, int> */
    public array $category_ids = [];

    public ?\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $featured_image = null;

    /**
     * Initialize the component with the given post's data.
     *
     * Authorizes the current user to update the post, then hydrates all form
     * properties from the post model, including tags and category IDs.
     *
     * @param  Post  $post  The post model instance to edit, resolved via route model binding.
     * @return void
     */
    public function mount(Post $post): void
    {
        $this->authorize('update', $post);

        $this->post = $post;
        $this->title = $post->title;
        $this->body = (string) $post->body;
        $this->status = $post->status;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt ?? '';
        $this->meta_title = $post->meta_title ?? '';
        $this->meta_description = $post->meta_description ?? '';
        $this->tags_input = $post->tags->pluck('name')->implode(', ');
        $this->category_ids = $post->categories->pluck('id')->map(fn($id): int => (int) $id)->toArray();
    }

    /**
     * Handle updates to the title property by conditionally auto-updating the slug.
     *
     * Only regenerates the slug from the new title if the current slug still matches
     * the slug derived from the original post title, preserving any manual slug edits.
     *
     * @return void
     */
    public function updatedTitle(): void
    {
        // Only auto-update slug if it matches the current title's slug
        $currentTitleSlug = Str::slug($this->post->title);
        if ($this->slug === $currentTitleSlug) {
            $this->slug = Str::slug($this->title);
        }
    }

    /**
     * Validate and persist updates to the post.
     *
     * Validates all form inputs, updates the post record, syncs categories and tags,
     * attaches a new featured image if uploaded, and sends notifications to other
     * users if the post transitions from draft to published. Redirects to the
     * posts index on success.
     *
     * @return void
     */
    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $this->post->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'tags_input' => ['nullable', 'string'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'max:1024'],
        ]);

        $wasPublished = $this->post->isPublished();

        if ($validated['status'] === 'published' && ! $this->post->published_at) {
            $validated['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $categoryIds = $validated['category_ids'] ?? [];
        unset($validated['category_ids']);

        $this->post->update($validated);

        $this->post->categories()->sync($categoryIds);

        if (! $wasPublished && $this->post->isPublished()) {
            $otherUsers = User::where('id', '!=', Auth::id())->get();
            Notification::send($otherUsers, new PostPublished($this->post));
            NewPostPublished::dispatch($this->post, Auth::user());
        }

        // Sync tags
        if ($this->tags_input !== '' && $this->tags_input !== '0') {
            $tags = array_filter(array_map(trim(...), explode(',', $this->tags_input)));
            $this->post->syncTags($tags);
        } else {
            $this->post->syncTags([]);
        }

        if ($this->featured_image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $this->post->addMedia($this->featured_image->getRealPath())
                ->usingFileName($this->featured_image->hashName())
                ->toMediaCollection('featured_image');
        }

        Toast::success('Post updated successfully.');

        $this->redirect(route('posts.index'), navigate: true);
    }

    /**
     * Check if the post has a featured image in the media collection.
     */
    public function hasFeaturedImage(): bool
    {
        return $this->post->hasMedia('featured_image');
    }

    /**
     * Clear the currently selected (not yet saved) uploaded image.
     */
    public function clearUploadedImage(): void
    {
        $this->featured_image = null;
    }

    /**
     * Remove the featured image from the post.
     *
     * Clears the 'featured_image' media collection on the post and displays
     * a success toast notification.
     */
    public function removeFeaturedImage(): void
    {
        $this->post->clearMediaCollection('featured_image');
        $this->toastSuccess('Featured image removed.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.posts.edit', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
