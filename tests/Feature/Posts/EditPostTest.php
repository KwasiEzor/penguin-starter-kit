<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders the edit post page', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('posts.edit', $post))
        ->assertOk();
});

it('updates a post with valid data', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('title', 'Updated Title')
        ->set('body', 'Updated body content.')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Title',
    ]);
});

it('prevents editing another users post', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->for($otherUser)->create();

    $this->actingAs($user)
        ->get(route('posts.edit', $post))
        ->assertForbidden();
});

it('validates required fields', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('title', '')
        ->set('body', '')
        ->call('save')
        ->assertHasErrors(['title', 'body']);
});
