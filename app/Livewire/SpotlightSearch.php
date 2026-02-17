<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class SpotlightSearch extends Component
{
    public string $query = '';

    public bool $open = false;

    public function updatedQuery(): void
    {
        $this->open = true;
    }

    public function close(): void
    {
        $this->open = false;
        $this->query = '';
    }

    public function render()
    {
        $results = [];

        if (strlen($this->query) >= 2) {
            $results = Post::query()
                ->where('user_id', Auth::id())
                ->where(fn ($q) => $q
                    ->where('title', 'like', "%{$this->query}%")
                    ->orWhere('body', 'like', "%{$this->query}%")
                )
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'status', 'created_at']);
        }

        // Static navigation items
        $pages = collect([
            ['name' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'home'],
            ['name' => 'Posts', 'url' => route('posts.index'), 'icon' => 'document-text'],
            ['name' => 'Create Post', 'url' => route('posts.create'), 'icon' => 'document-text'],
            ['name' => 'Settings', 'url' => route('settings'), 'icon' => 'cog'],
        ])->when(strlen($this->query) >= 1, fn ($c) => $c->filter(
            fn ($p) => str_contains(strtolower($p['name']), strtolower($this->query))
        ));

        return view('livewire.spotlight-search', [
            'results' => $results,
            'pages' => $pages,
        ]);
    }
}
