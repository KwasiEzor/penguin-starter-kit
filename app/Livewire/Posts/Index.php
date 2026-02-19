<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Livewire\Concerns\HasToast;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast;
    use WithPagination;

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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $posts = Post::query()
            ->with('tags')
            ->where('user_id', Auth::id())
            ->when($this->search, fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where(function (\Illuminate\Database\Eloquent\Builder $q): void {
                $q->where('title', 'like', sprintf('%%%s%%', $this->search))
                    ->orWhere('body', 'like', sprintf('%%%s%%', $this->search));
            }))
            ->when($this->statusFilter, fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where('status', $this->statusFilter))
            ->when($this->tagFilter, fn (\Illuminate\Database\Eloquent\Builder $q) => $q->withAnyTags([$this->tagFilter]))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $userPostIds = Post::where('user_id', Auth::id())->pluck('id');

        $availableTags = \Spatie\Tags\Tag::query()
            ->whereExists(function (\Illuminate\Database\Query\Builder $q) use ($userPostIds): void {
                $q->select(\Illuminate\Support\Facades\DB::raw(1))
                    ->from('taggables')
                    ->whereColumn('taggables.tag_id', 'tags.id')
                    ->where('taggables.taggable_type', Post::class)
                    ->whereIn('taggables.taggable_id', $userPostIds);
            })
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        return view('livewire.posts.index', ['posts' => $posts, 'availableTags' => $availableTags]);
    }
}
