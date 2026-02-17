<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders the posts index for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertOk();
});

it('redirects guests to login', function () {
    $this->get(route('posts.index'))
        ->assertRedirect(route('login'));
});

it('shows only the authenticated users posts', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Post::factory()->for($user)->create(['title' => 'My Post']);
    Post::factory()->for($otherUser)->create(['title' => 'Other Post']);

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSee('My Post')
        ->assertDontSee('Other Post');
});

it('can search posts', function () {
    $user = User::factory()->create();
    Post::factory()->for($user)->create(['title' => 'Laravel Tips']);
    Post::factory()->for($user)->create(['title' => 'Vue Guide']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('search', 'Laravel')
        ->assertSee('Laravel Tips')
        ->assertDontSee('Vue Guide');
});

it('can filter posts by status', function () {
    $user = User::factory()->create();
    Post::factory()->for($user)->published()->create(['title' => 'Published One']);
    Post::factory()->for($user)->draft()->create(['title' => 'Draft One']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('statusFilter', 'published')
        ->assertSee('Published One')
        ->assertDontSee('Draft One');
});

it('can delete a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->call('confirmDelete', $post->id)
        ->call('deletePost');

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('shows empty state when no posts exist', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSee('No posts found');
});
