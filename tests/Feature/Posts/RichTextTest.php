<?php

/**
 * Tests for rich text (HTML) content handling in posts.
 *
 * Verifies that posts can be created and updated with HTML body content,
 * rich text is rendered correctly on the blog show page, and body
 * content is validated as required.
 */

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('creates a post with HTML body via Livewire', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Rich Text Post')
        ->set('body', '<div><strong>Bold text</strong> and <em>italic text</em></div>')
        ->set('status', 'draft')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'Rich Text Post')->first();
    expect($post)->not->toBeNull();
    expect((string) $post->body)->toContain('<strong>Bold text</strong>');
});

it('updates a post with HTML body', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('body', '<div><h1>Updated heading</h1><p>New paragraph</p></div>')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post->refresh();
    expect((string) $post->body)->toContain('<h1>Updated heading</h1>');
});

it('renders rich text body on blog show page', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create([
        'body' => '<div><strong>Bold content</strong></div>',
    ]);

    $this->get(route('blog.show', $post->slug))
        ->assertOk()
        ->assertSee('<strong>Bold content</strong>', false);
});

it('validates body is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Test Post')
        ->set('body', '')
        ->call('save')
        ->assertHasErrors(['body']);
});
