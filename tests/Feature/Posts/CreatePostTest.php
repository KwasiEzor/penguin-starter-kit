<?php

/**
 * Tests for the post creation workflow.
 *
 * Verifies that the create post page renders, posts can be created with valid data,
 * the published_at timestamp is set when status is published, and required field
 * validation is enforced.
 */

use App\Models\User;
use Livewire\Livewire;

it('renders the create post page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.create'))
        ->assertOk();
});

it('creates a post with valid data', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'My New Post')
        ->set('body', 'This is the post content.')
        ->set('status', 'draft')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseHas('posts', [
        'title' => 'My New Post',
        'user_id' => $user->id,
        'status' => 'draft',
    ]);
});

it('sets published_at when status is published', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Published Post')
        ->set('body', 'Content here.')
        ->set('status', 'published')
        ->call('save');

    $post = \App\Models\Post::where('title', 'Published Post')->first();
    expect($post->published_at)->not->toBeNull();
});

it('validates required fields', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', '')
        ->set('body', '')
        ->call('save')
        ->assertHasErrors(['title', 'body']);
});
