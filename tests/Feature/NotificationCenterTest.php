<?php

/**
 * Tests for the notification center Livewire component and notification dispatching.
 *
 * Covers rendering the notification center, displaying unread counts, marking
 * individual and all notifications as read, showing an empty state, and
 * verifying that notifications are sent to other users when a post is published
 * (but not for drafts or when editing an already-published post).
 */

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished;
use Livewire\Livewire;

it('renders the notification center', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('Notifications');
});

it('shows unread notification count', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create();
    $user->notify(new PostPublished($post));

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('1');
});

it('can mark a notification as read', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create();
    $user->notify(new PostPublished($post));

    $notification = $user->unreadNotifications()->first();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->call('markAsRead', $notification->id);

    expect($user->fresh()->unreadNotifications()->count())->toBe(0);
});

it('can mark all notifications as read', function (): void {
    $user = User::factory()->create();
    $posts = Post::factory(3)->for($user)->published()->create();

    $posts->each(fn ($post) => $user->notify(new PostPublished($post)));

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->call('markAllAsRead');

    expect($user->fresh()->unreadNotifications()->count())->toBe(0);
});

it('shows empty state when no notifications', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('No notifications yet');
});

it('sends notification to other users when post is published', function (): void {
    $author = User::factory()->create();
    $otherUser = User::factory()->create();

    Livewire::actingAs($author)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Notify Post')
        ->set('body', 'Content here.')
        ->set('status', 'published')
        ->call('save');

    expect($author->fresh()->notifications()->count())->toBe(0);
    expect($otherUser->fresh()->notifications()->count())->toBe(1);
});

it('does not send notification for draft posts', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Draft Post')
        ->set('body', 'Content here.')
        ->set('status', 'draft')
        ->call('save');

    expect($user->fresh()->notifications()->count())->toBe(0);
    expect($otherUser->fresh()->notifications()->count())->toBe(0);
});

it('sends notification when draft is changed to published via edit', function (): void {
    $author = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->for($author)->create([
        'status' => 'draft',
        'published_at' => null,
    ]);

    Livewire::actingAs($author)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('status', 'published')
        ->call('save');

    expect($author->fresh()->notifications()->count())->toBe(0);
    expect($otherUser->fresh()->notifications()->count())->toBe(1);
});

it('does not send notification when editing an already published post', function (): void {
    $author = User::factory()->create();
    $otherUser = User::factory()->create();

    $post = Post::factory()->for($author)->published()->create();

    Livewire::actingAs($author)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('title', 'Updated Title')
        ->call('save');

    expect($otherUser->fresh()->notifications()->count())->toBe(0);
});
