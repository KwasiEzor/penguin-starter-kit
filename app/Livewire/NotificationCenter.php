<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class NotificationCenter extends Component
{
    public function markAsRead(string $id): void
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ?->markAsRead();
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.notification-center', [
            'notifications' => Auth::user()->notifications()->latest()->take(10)->get(),
            'unreadCount' => Auth::user()->unreadNotifications()->count(),
        ]);
    }
}
