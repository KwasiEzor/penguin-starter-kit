<?php

/**
 * Tests for the NewPostPublished broadcast event.
 *
 * Verifies that the event is dispatched when a post is published (and not
 * for drafts), that it broadcasts to private channels for all users except
 * the author, that the broadcast payload contains the expected data, and
 * that the correct broadcast event name is used.
 */

use App\Events\NewPostPublished;
use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Event;

it('dispatches the event when a post is published via create', function (): void {
    Event::fake([NewPostPublished::class]);

    $author = User::factory()->create();
    User::factory()->create(); // another user

    Livewire\Livewire::actingAs($author)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Broadcast Test')
        ->set('body', 'Content here.')
        ->set('status', 'published')
        ->call('save');

    Event::assertDispatched(NewPostPublished::class);
});

it('does not dispatch the event for draft posts', function (): void {
    Event::fake([NewPostPublished::class]);

    $author = User::factory()->create();

    Livewire\Livewire::actingAs($author)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Draft Post')
        ->set('body', 'Content here.')
        ->set('status', 'draft')
        ->call('save');

    Event::assertNotDispatched(NewPostPublished::class);
});

it('broadcasts to private channels excluding the author', function (): void {
    $author = User::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $post = Post::factory()->for($author)->published()->create();

    $event = new NewPostPublished($post, $author);
    $channels = $event->broadcastOn();

    $channelNames = array_map(fn (PrivateChannel $ch) => $ch->name, $channels);

    expect($channelNames)->toContain('private-App.Models.User.'.$user1->id)
        ->toContain('private-App.Models.User.'.$user2->id)
        ->not->toContain('private-App.Models.User.'.$author->id);
});

it('returns the correct broadcast payload', function (): void {
    $author = User::factory()->create(['name' => 'Jane Doe']);
    $post = Post::factory()->for($author)->published()->create(['title' => 'My Post']);

    $event = new NewPostPublished($post, $author);
    $payload = $event->broadcastWith();

    expect($payload)->toHaveKeys(['post_id', 'title', 'author', 'message'])
        ->and($payload['post_id'])->toBe($post->id)
        ->and($payload['title'])->toBe('My Post')
        ->and($payload['author'])->toBe('Jane Doe')
        ->and($payload['message'])->toContain('My Post')
        ->toContain('Jane Doe');
});

it('uses the correct broadcast name', function (): void {
    $author = User::factory()->create();
    $post = Post::factory()->for($author)->published()->create();

    $event = new NewPostPublished($post, $author);

    expect($event->broadcastAs())->toBe('post.published');
});
