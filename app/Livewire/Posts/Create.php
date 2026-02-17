<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Notifications\PostPublished;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Create extends Component
{
    use HasToast;

    public string $title = '';

    public string $body = '';

    public string $status = 'draft';

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Auth::user()->posts()->create($validated);

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
