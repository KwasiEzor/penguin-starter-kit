<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Events\NewPostPublished;
use App\Livewire\Concerns\HasToast;
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

    public ?\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $featured_image = null;

    private string $previousAutoSlug = '';

    public function updatedTitle(): void
    {
        $newAutoSlug = Str::slug($this->title);

        if ($this->slug === '' || $this->slug === $this->previousAutoSlug) {
            $this->slug = $newAutoSlug;
        }

        $this->previousAutoSlug = $newAutoSlug;
    }

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
            'featured_image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Auth::user()->posts()->create($validated);

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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.posts.create');
    }
}
