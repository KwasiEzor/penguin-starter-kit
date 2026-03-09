<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

final class NotifyUsersOfNewPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Post $post,
        public readonly int $authorId
    ) {}

    public function handle(): void
    {
        User::where('id', '!=', $this->authorId)
            ->chunk(100, function ($users) {
                Notification::send($users, new PostPublished($this->post));
            });
    }
}
