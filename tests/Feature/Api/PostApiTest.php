<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns unauthenticated without token', function () {
    $this->getJson('/api/posts')
        ->assertUnauthorized();
});

it('lists the authenticated users posts', function () {
    $user = User::factory()->create();
    Post::factory(3)->for($user)->create();
    Post::factory(2)->create(); // other user

    Sanctum::actingAs($user);

    $this->getJson('/api/posts')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

it('creates a post via api', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/posts', [
        'title' => 'API Post',
        'body' => 'Created via API.',
        'status' => 'draft',
    ])
        ->assertCreated()
        ->assertJsonPath('data.title', 'API Post');

    $this->assertDatabaseHas('posts', ['title' => 'API Post', 'user_id' => $user->id]);
});

it('shows a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $this->getJson("/api/posts/{$post->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $post->id);
});

it('updates a post via api', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $this->putJson("/api/posts/{$post->id}", ['title' => 'Updated'])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated');
});

it('deletes a post via api', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Sanctum::actingAs($user);

    $this->deleteJson("/api/posts/{$post->id}")
        ->assertOk();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('prevents accessing another users post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(); // another user

    Sanctum::actingAs($user);

    $this->getJson("/api/posts/{$post->id}")
        ->assertForbidden();
});

it('returns the authenticated user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->getJson('/api/user')
        ->assertOk()
        ->assertJsonPath('email', $user->email);
});
