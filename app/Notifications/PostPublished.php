<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notification sent to users when a new post is published.
 *
 * This notification is stored in the database and displayed to users
 * via the in-app notification system. It contains the post title and
 * a formatted message about the publication.
 */
final class PostPublished extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  Post  $post  The post that was published
     */
    public function __construct(
        public readonly Post $post
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  object  $notifiable  The entity being notified
     * @return array<int, string> The list of channels (database)
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  object  $notifiable  The entity being notified
     * @return array<string, mixed> The notification data containing post_id, title, and message
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'message' => sprintf('The post "%s" has been published.', $this->post->title),
        ];
    }
}
