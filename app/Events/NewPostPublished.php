<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event dispatched when a new post is published.
 *
 * This event is broadcast to all users (except the author) via private channels
 * using Laravel Reverb, enabling real-time notifications in the UI when new
 * content becomes available.
 */
final class NewPostPublished implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  Post  $post  The post that was published
     * @param  User  $author  The user who published the post
     */
    public function __construct(
        public readonly Post $post,
        public readonly User $author,
    ) {}

    /**
     * @return array<int, PrivateChannel>
     */
    public function broadcastOn(): array
    {
        return User::where('id', '!=', $this->author->id)
            ->pluck('id')
            ->map(fn (int $id): \Illuminate\Broadcasting\PrivateChannel => new PrivateChannel('App.Models.User.'.$id))
            ->all();
    }

    /**
     * Get the broadcast event name.
     *
     * @return string The event name used on the client side
     */
    public function broadcastAs(): string
    {
        return 'post.published';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'author' => $this->author->name,
            'message' => sprintf('"%s" was just published by %s.', $this->post->title, $this->author->name),
        ];
    }
}
