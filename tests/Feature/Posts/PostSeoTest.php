<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('auto-generates slug from title when creating a post', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'My Amazing Post')
        ->set('body', 'Some content here.')
        ->set('status', 'draft')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'My Amazing Post')->first();
    expect($post->slug)->toBe('my-amazing-post');
});

it('generates unique slug on collision', function (): void {
    $user = User::factory()->create();

    // Create first post with slug
    $user->posts()->create([
        'title' => 'Duplicate Title',
        'slug' => 'duplicate-title',
        'body' => 'First post.',
        'status' => 'draft',
    ]);

    // Create second post with same title — slug should auto-increment
    $second = $user->posts()->create([
        'title' => 'Duplicate Title',
        'body' => 'Second post.',
        'status' => 'draft',
    ]);

    expect($second->slug)->toBe('duplicate-title-2');
});

it('creates post with all SEO fields', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'SEO Optimized Post')
        ->set('body', 'Content for SEO.')
        ->set('status', 'draft')
        ->set('slug', 'custom-seo-slug')
        ->set('excerpt', 'A short summary of the post.')
        ->set('meta_title', 'Custom Meta Title')
        ->set('meta_description', 'Custom meta description for SEO.')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'SEO Optimized Post')->first();
    expect($post->slug)->toBe('custom-seo-slug');
    expect($post->excerpt)->toBe('A short summary of the post.');
    expect($post->meta_title)->toBe('Custom Meta Title');
    expect($post->meta_description)->toBe('Custom meta description for SEO.');
});

it('updates SEO fields on an existing post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create(['slug' => 'original-slug']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('slug', 'updated-slug')
        ->set('excerpt', 'Updated excerpt.')
        ->set('meta_title', 'Updated Meta')
        ->set('meta_description', 'Updated description.')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post->refresh();
    expect($post->slug)->toBe('updated-slug');
    expect($post->excerpt)->toBe('Updated excerpt.');
    expect($post->meta_title)->toBe('Updated Meta');
    expect($post->meta_description)->toBe('Updated description.');
});

it('auto-generates excerpt from body when empty', function (): void {
    $user = User::factory()->create();
    $body = str_repeat('This is a long body text. ', 20);

    $post = $user->posts()->create([
        'title' => 'Excerpt Test',
        'body' => $body,
        'status' => 'draft',
    ]);

    expect($post->getExcerpt())->toHaveLength(163); // 160 chars + '...'
});

it('returns custom excerpt when set', function (): void {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'title' => 'Custom Excerpt',
        'body' => 'Full body content here.',
        'excerpt' => 'My custom excerpt.',
        'status' => 'draft',
    ]);

    expect($post->getExcerpt())->toBe('My custom excerpt.');
});

it('validates meta_title max 60 characters', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Test Post')
        ->set('body', 'Content.')
        ->set('meta_title', str_repeat('a', 61))
        ->call('save')
        ->assertHasErrors(['meta_title']);
});

it('validates meta_description max 160 characters', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Test Post')
        ->set('body', 'Content.')
        ->set('meta_description', str_repeat('a', 161))
        ->call('save')
        ->assertHasErrors(['meta_description']);
});
