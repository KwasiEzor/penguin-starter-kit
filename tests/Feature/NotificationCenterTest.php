<?php

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished;
use Livewire\Livewire;

it('renders the notification center', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('Notifications');
});

it('shows unread notification count', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create();
    $user->notify(new PostPublished($post));

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('1');
});

it('can mark a notification as read', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create();
    $user->notify(new PostPublished($post));

    $notification = $user->unreadNotifications()->first();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->call('markAsRead', $notification->id);

    expect($user->fresh()->unreadNotifications()->count())->toBe(0);
});

it('can mark all notifications as read', function () {
    $user = User::factory()->create();
    $posts = Post::factory(3)->for($user)->published()->create();

    $posts->each(fn ($post) => $user->notify(new PostPublished($post)));

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->call('markAllAsRead');

    expect($user->fresh()->unreadNotifications()->count())->toBe(0);
});

it('shows empty state when no notifications', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\NotificationCenter::class)
        ->assertSee('No notifications yet');
});

it('sends notification when post is published', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Notify Post')
        ->set('body', 'Content here.')
        ->set('status', 'published')
        ->call('save');

    expect($user->fresh()->notifications()->count())->toBe(1);
});

it('does not send notification for draft posts', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Draft Post')
        ->set('body', 'Content here.')
        ->set('status', 'draft')
        ->call('save');

    expect($user->fresh()->notifications()->count())->toBe(0);
});
