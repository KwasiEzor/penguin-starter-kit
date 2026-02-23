<?php

/**
 * Tests for the Category model.
 *
 * Verifies that categories auto-generate slugs from their names
 * and maintain correct polymorphic relationships with posts.
 */

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

it('auto-generates slug from name', function (): void {
    $category = Category::create(['name' => 'Web Development']);

    expect($category->slug)->toBe('web-development');
});

it('has polymorphic relationship with posts', function (): void {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->for($user)->create();

    $post->categories()->attach($category);

    expect($category->posts)->toHaveCount(1);
    expect($category->posts->first()->id)->toBe($post->id);
    expect($post->categories)->toHaveCount(1);
    expect($post->categories->first()->id)->toBe($category->id);
});
