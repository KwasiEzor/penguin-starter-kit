<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\HasToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

final class NotificationCenter extends Component
{
    use HasToast;

    public function getUserIdProperty(): int
    {
        return Auth::id();
    }

    #[On('echo-private:App.Models.User.{userId},post.published')]
    public function onPostPublished(array $data): void
    {
        $this->toastInfo($data['message'] ?? 'A new post was published.');
    }

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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.notification-center', [
            'notifications' => Auth::user()->notifications()->latest()->take(10)->get(),
            'unreadCount' => Auth::user()->unreadNotifications()->count(),
        ]);
    }
}
