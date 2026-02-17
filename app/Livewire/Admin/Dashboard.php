<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalUsers' => User::count(),
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'published')->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentPosts' => Post::with('user')->latest()->take(5)->get(),
        ]);
    }
}
