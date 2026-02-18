<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast, WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $tagFilter = '';

    public ?int $deletingPostId = null;

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTagFilter(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingPostId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingPostId = null;
    }

    public function deletePost(): void
    {
        $post = Post::findOrFail($this->deletingPostId);
        $this->authorize('delete', $post);
        $post->delete();

        $this->deletingPostId = null;
        $this->toastSuccess('Post deleted successfully.');
    }

    public function render()
    {
        $posts = Post::query()
            ->with('tags')
            ->where('user_id', Auth::id())
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('body', 'like', "%{$this->search}%");
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->tagFilter, fn ($q) => $q->withAnyTags([$this->tagFilter]))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $userPostIds = Post::where('user_id', Auth::id())->pluck('id');

        $availableTags = \Spatie\Tags\Tag::query()
            ->whereExists(function ($q) use ($userPostIds) {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                    ->from('taggables')
                    ->whereColumn('taggables.tag_id', 'tags.id')
                    ->where('taggables.taggable_type', Post::class)
                    ->whereIn('taggables.taggable_id', $userPostIds);
            })
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        return view('livewire.posts.index', compact('posts', 'availableTags'));
    }
}
