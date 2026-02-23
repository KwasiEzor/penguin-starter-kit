<?php

/**
 * Tests for the Post model.
 *
 * Verifies the user relationship and the ability to determine
 * whether a post is published or in draft status.
 */

use App\Models\Post;
use App\Models\User;

it('belongs to a user', function (): void {
    $post = Post::factory()->create();

    expect($post->user)->toBeInstanceOf(User::class);
});

it('determines if published', function (): void {
    $published = Post::factory()->published()->create();
    $draft = Post::factory()->draft()->create();

    expect($published->isPublished())->toBeTrue();
    expect($draft->isPublished())->toBeFalse();
});
