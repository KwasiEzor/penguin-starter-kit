<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Models\Post;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
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

    public $featured_image;

    public function mount(Post $post): void
    {
        $this->authorize('update', $post);

        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->status = $post->status;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validated['status'] === 'published' && ! $this->post->published_at) {
            $validated['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $this->post->update($validated);

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
