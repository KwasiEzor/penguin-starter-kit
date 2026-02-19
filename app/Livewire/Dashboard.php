<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Dashboard extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = Auth::user();

        $myPosts = Post::where('user_id', $user->id);
        $totalPosts = $myPosts->count();
        $publishedPosts = (clone $myPosts)->where('status', 'published')->count();
        $draftPosts = (clone $myPosts)->where('status', 'draft')->count();

        $recentPosts = Post::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $postsThisWeek = Post::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        $unreadNotifications = $user->unreadNotifications()->count();

        return view('livewire.dashboard', [
            'totalPosts' => $totalPosts,
            'publishedPosts' => $publishedPosts,
            'draftPosts' => $draftPosts,
            'recentPosts' => $recentPosts,
            'postsThisWeek' => $postsThisWeek,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
}
