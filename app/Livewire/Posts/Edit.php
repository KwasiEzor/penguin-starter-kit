<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Events\NewPostPublished;
use App\Livewire\Concerns\HasToast;
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

#[Layout('components.layouts.app')]
final class Edit extends Component
{
    use HasToast, WithFileUploads;

    public Post $post;

    public string $title = '';

    public string $body = '';

    public string $status = 'draft';

    public string $slug = '';

    public string $excerpt = '';

    public string $meta_title = '';

    public string $meta_description = '';

    public string $tags_input = '';

    public $featured_image;

    public function mount(Post $post): void
    {
        $this->authorize('update', $post);

        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->status = $post->status;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt ?? '';
        $this->meta_title = $post->meta_title ?? '';
        $this->meta_description = $post->meta_description ?? '';
        $this->tags_input = $post->tags->pluck('name')->implode(', ');
    }

    public function updatedTitle(): void
    {
        // Only auto-update slug if it matches the current title's slug
        $currentTitleSlug = Str::slug($this->post->title);
        if ($this->slug === $currentTitleSlug) {
            $this->slug = Str::slug($this->title);
        }
    }

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
            'featured_image' => ['nullable', 'image', 'max:1024'],
        ]);

        $wasPublished = $this->post->isPublished();

        if ($validated['status'] === 'published' && ! $this->post->published_at) {
            $validated['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $this->post->update($validated);

        if (! $wasPublished && $this->post->isPublished()) {
            $otherUsers = User::where('id', '!=', Auth::id())->get();
            Notification::send($otherUsers, new PostPublished($this->post));
            NewPostPublished::dispatch($this->post, Auth::user());
        }

        // Sync tags
        if (! empty($this->tags_input)) {
            $tags = array_filter(array_map('trim', explode(',', $this->tags_input)));
            $this->post->syncTags($tags);
        } else {
            $this->post->syncTags([]);
        }

        if ($this->featured_image) {
            $this->post->addMedia($this->featured_image->getRealPath())
                ->usingFileName($this->featured_image->hashName())
                ->toMediaCollection('featured_image');
        }

        Toast::success('Post updated successfully.');

        $this->redirect(route('posts.index'), navigate: true);
    }

    public function removeFeaturedImage(): void
    {
        $this->post->clearMediaCollection('featured_image');
        $this->toastSuccess('Featured image removed.');
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }
}
