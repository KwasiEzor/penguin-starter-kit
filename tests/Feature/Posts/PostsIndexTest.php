<?php

/**
 * Tests for the posts index page.
 *
 * Verifies that the index renders for authenticated users, redirects guests,
 * shows only the authenticated user's posts, supports search and status filtering,
 * allows post deletion, and displays an empty state when no posts exist.
 */

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders the posts index for authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertOk();
});

it('redirects guests to login', function (): void {
    $this->get(route('posts.index'))
        ->assertRedirect(route('login'));
});

it('shows only the authenticated users posts', function (): void {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Post::factory()->for($user)->create(['title' => 'My Post']);
    Post::factory()->for($otherUser)->create(['title' => 'Other Post']);

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSee('My Post')
        ->assertDontSee('Other Post');
});

it('can search posts', function (): void {
    $user = User::factory()->create();
    Post::factory()->for($user)->create(['title' => 'Laravel Tips']);
    Post::factory()->for($user)->create(['title' => 'Vue Guide']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('search', 'Laravel')
        ->assertSee('Laravel Tips')
        ->assertDontSee('Vue Guide');
});

it('can filter posts by status', function (): void {
    $user = User::factory()->create();
    Post::factory()->for($user)->published()->create(['title' => 'Published One']);
    Post::factory()->for($user)->draft()->create(['title' => 'Draft One']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('statusFilter', 'published')
        ->assertSee('Published One')
        ->assertDontSee('Draft One');
});

it('can delete a post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->call('confirmDelete', $post->id)
        ->call('deletePost');

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('shows empty state when no posts exist', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSee('No posts found');
});
