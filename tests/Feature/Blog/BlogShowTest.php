<?php

/**
 * Tests for the public blog post show page.
 *
 * Verifies that published posts are viewable by slug, that draft and
 * non-existent posts return 404 responses, that Open Graph meta tags are
 * rendered correctly, that tags are displayed, and that the page is
 * accessible without authentication.
 */

use App\Models\Post;
use App\Models\User;

it('shows a published post by slug', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create([
        'title' => 'Published Blog Post',
        'slug' => 'published-blog-post',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->get(route('blog.show', 'published-blog-post'))
        ->assertOk()
        ->assertSee('Published Blog Post');
});

it('returns 404 for draft posts', function (): void {
    $user = User::factory()->create();
    Post::factory()->for($user)->create([
        'slug' => 'draft-post',
        'status' => 'draft',
    ]);

    $this->get(route('blog.show', 'draft-post'))
        ->assertNotFound();
});

it('returns 404 for non-existent slug', function (): void {
    $this->get(route('blog.show', 'does-not-exist'))
        ->assertNotFound();
});

it('displays OG meta tags in head', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create([
        'title' => 'Meta Tags Post',
        'slug' => 'meta-tags-post',
        'status' => 'published',
        'published_at' => now(),
        'meta_title' => 'Custom OG Title',
        'meta_description' => 'Custom OG description for testing.',
    ]);

    $this->get(route('blog.show', 'meta-tags-post'))
        ->assertOk()
        ->assertSee('og:title', false)
        ->assertSee('Custom OG Title', false)
        ->assertSee('og:description', false)
        ->assertSee('Custom OG description for testing.', false);
});

it('shows tags on the blog post page', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create([
        'slug' => 'tagged-blog-post',
        'status' => 'published',
        'published_at' => now(),
    ]);
    $post->attachTags(['Laravel', 'Tutorial']);

    $this->get(route('blog.show', 'tagged-blog-post'))
        ->assertOk()
        ->assertSee('Laravel')
        ->assertSee('Tutorial');
});

it('is accessible without authentication', function (): void {
    $user = User::factory()->create();
    Post::factory()->for($user)->create([
        'slug' => 'public-post',
        'status' => 'published',
        'published_at' => now(),
    ]);

    // Ensure no user is logged in
    $this->assertGuest();

    $this->get(route('blog.show', 'public-post'))
        ->assertOk();
});
