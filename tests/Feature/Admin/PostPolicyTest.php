<?php

use App\Models\Post;
use App\Models\User;

it('allows a user to update their own post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    expect($user->can('update', $post))->toBeTrue();
});

it('prevents a user from updating another users post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    expect($user->can('update', $post))->toBeFalse();
});

it('allows an admin to update any post', function (): void {
    $admin = User::factory()->admin()->create();
    $post = Post::factory()->create();

    expect($admin->can('update', $post))->toBeTrue();
});

it('allows a user to delete their own post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    expect($user->can('delete', $post))->toBeTrue();
});

it('allows an admin to delete any post', function (): void {
    $admin = User::factory()->admin()->create();
    $post = Post::factory()->create();

    expect($admin->can('delete', $post))->toBeTrue();
});

it('prevents a user from deleting another users post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    expect($user->can('delete', $post))->toBeFalse();
});
