<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Models\Post;
use App\Support\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Edit extends Component
{
    use HasToast;

    public Post $post;

    public string $title = '';

    public string $body = '';

    public string $status = 'draft';

    public function mount(Post $post): void
    {
        abort_unless($post->user_id === Auth::id(), 403);

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
        ]);

        if ($validated['status'] === 'published' && ! $this->post->published_at) {
            $validated['published_at'] = now();
        }

        if ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $this->post->update($validated);

        Toast::success('Post updated successfully.');

        $this->redirect(route('posts.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }
}
