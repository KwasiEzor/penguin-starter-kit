<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Notifications\PostPublished;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
final class Create extends Component
{
    use HasToast, WithFileUploads;

    public string $title = '';

    public string $body = '';

    public string $status = 'draft';

    public $featured_image;

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Auth::user()->posts()->create($validated);

        if ($this->featured_image) {
            $post->addMedia($this->featured_image->getRealPath())
                ->usingFileName($this->featured_image->hashName())
                ->toMediaCollection('featured_image');
        }

        if ($post->isPublished()) {
            Auth::user()->notify(new PostPublished($post));
        }

        Toast::success('Post created successfully.');

        $this->redirect(route('posts.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.posts.create');
    }
}
