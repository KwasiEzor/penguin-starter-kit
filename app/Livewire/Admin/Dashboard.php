<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Dashboard extends Component
{
    public function render()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'published')->count(),
            'recentUsers' => User::with('roles')->latest()->take(5)->get(),
            'recentPosts' => Post::with('user')->latest()->take(5)->get(),
            'paymentsEnabled' => Setting::paymentsEnabled(),
        ];

        if ($data['paymentsEnabled']) {
            $data['activeSubscriptions'] = User::whereHas('subscriptions', function ($q) {
                $q->where('stripe_status', 'active');
            })->count();
            $data['monthlyRevenue'] = Order::where('status', 'completed')
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('amount');
        }

        return view('livewire.admin.dashboard', $data);
    }
}
