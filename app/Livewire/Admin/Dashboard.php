<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\AiExecution;
use App\Models\Order;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Flowframe\Trend\Trend;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component for the admin dashboard overview.
 *
 * Displays key metrics including total users, posts, published posts,
 * recent activity, and optionally subscription and revenue data when
 * payments are enabled. Includes interactive charts for user growth
 * and AI usage trends.
 */
#[Layout('components.layouts.app')]
final class Dashboard extends Component
{
    /**
     * Render the dashboard view with aggregated statistics and recent activity.
     *
     * Includes payment-related metrics (active subscriptions, monthly revenue)
     * only when the payments feature is enabled.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $userTrend = Trend::model(User::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->count();

        $tokenTrend = Trend::model(AiExecution::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->sum('tokens_output');

        $data = [
            'totalUsers' => User::count(),
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'published')->count(),
            'recentUsers' => User::with('roles')->latest()->take(5)->get(),
            'recentPosts' => Post::with('user')->latest()->take(5)->get(),
            'paymentsEnabled' => Setting::paymentsEnabled(),
            'userTrend' => [
                'labels' => $userTrend->map(fn ($t) => $t->date)->toArray(),
                'data' => $userTrend->map(fn ($t) => $t->aggregate)->toArray(),
            ],
            'tokenTrend' => [
                'labels' => $tokenTrend->map(fn ($t) => $t->date)->toArray(),
                'data' => $tokenTrend->map(fn ($t) => $t->aggregate)->toArray(),
            ],
        ];

        if ($data['paymentsEnabled']) {
            $data['activeSubscriptions'] = User::whereHas('subscriptions', function (\Illuminate\Database\Eloquent\Builder $q): void {
                $q->where('stripe_status', 'active');
            })->count();
            $data['monthlyRevenue'] = Order::where('status', 'completed')
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('amount');
        }

        return view('livewire.admin.dashboard', $data);
    }
}
