<?php

use App\Models\Post;
use App\Models\User;

it('belongs to a user', function () {
    $post = Post::factory()->create();

    expect($post->user)->toBeInstanceOf(User::class);
});

it('determines if published', function () {
    $published = Post::factory()->published()->create();
    $draft = Post::factory()->draft()->create();

    expect($published->isPublished())->toBeTrue();
    expect($draft->isPublished())->toBeFalse();
});
