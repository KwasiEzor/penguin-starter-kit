<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Events\NewPostPublished;
use App\Livewire\Concerns\HasToast;
use App\Models\Category;
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
 * Livewire component for creating a new blog post.
 *
 * Provides a form for authenticated users to compose a post with a title, body,
 * slug, excerpt, SEO metadata, tags, categories, and an optional featured image.
 * Automatically generates a slug from the title and dispatches notifications
 * when a post is published.
 */
#[Layout('components.layouts.app')]
final class Create extends Component
{
    use HasToast;
    use WithFileUploads;

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

    private string $previousAutoSlug = '';

    /**
     * Handle updates to the title property by auto-generating a slug.
     *
     * Automatically derives a URL-friendly slug from the title whenever it changes,
     * unless the user has manually customized the slug to differ from the auto-generated value.
     *
     * @return void
     */
    public function updatedTitle(): void
    {
        $newAutoSlug = Str::slug($this->title);

        if ($this->slug === '' || $this->slug === $this->previousAutoSlug) {
            $this->slug = $newAutoSlug;
        }

        $this->previousAutoSlug = $newAutoSlug;
    }

    /**
     * Validate and persist the new post to the database.
     *
     * Validates all form inputs, creates the post associated with the authenticated user,
     * syncs categories and tags, attaches a featured image if provided, and sends
     * notifications to other users when the post is published. Redirects to the
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
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'tags_input' => ['nullable', 'string'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $categoryIds = $validated['category_ids'] ?? [];
        unset($validated['category_ids']);

        $post = Auth::user()->posts()->create($validated);

        if (! empty($categoryIds)) {
            $post->categories()->sync($categoryIds);
        }

        // Sync tags
        if ($this->tags_input !== '' && $this->tags_input !== '0') {
            $tags = array_filter(array_map(trim(...), explode(',', $this->tags_input)));
            $post->syncTags($tags);
        }

        if ($this->featured_image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $post->addMedia($this->featured_image->getRealPath())
                ->usingFileName($this->featured_image->hashName())
                ->toMediaCollection('featured_image');
        }

        if ($post->isPublished()) {
            $otherUsers = User::where('id', '!=', Auth::id())->get();
            Notification::send($otherUsers, new PostPublished($post));
            NewPostPublished::dispatch($post, Auth::user());
        }

        Toast::success('Post created successfully.');

        $this->redirect(route('posts.index'), navigate: true);
    }

    /**
     * Render the post creation form view.
     *
     * Passes the list of available categories (sorted alphabetically) to the view
     * for category selection.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.posts.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
