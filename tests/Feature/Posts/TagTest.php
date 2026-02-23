<?php

/**
 * Tests for the post tagging functionality.
 *
 * Covers creating posts with comma-separated tags, automatic creation of new tags,
 * syncing tags when editing a post, removing all tags, filtering posts by tag
 * on the index page, and displaying tags as badges.
 */

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('creates a post with tags via comma-separated input', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Tagged Post')
        ->set('body', 'Content with tags.')
        ->set('status', 'draft')
        ->set('tags_input', 'Laravel, PHP, Testing')
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'Tagged Post')->first();
    expect($post->tags->pluck('name')->toArray())->toEqualCanonicalizing(['Laravel', 'PHP', 'Testing']);
});

it('creates tags that do not exist yet', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'New Tags Post')
        ->set('body', 'Content.')
        ->set('status', 'draft')
        ->set('tags_input', 'BrandNewTag, AnotherNewTag')
        ->call('save');

    expect(\Spatie\Tags\Tag::where('name->en', 'BrandNewTag')->exists())->toBeTrue();
    expect(\Spatie\Tags\Tag::where('name->en', 'AnotherNewTag')->exists())->toBeTrue();
});

it('syncs tags properly when editing a post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $post->attachTags(['Laravel', 'PHP']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->assertSet('tags_input', 'Laravel, PHP')
        ->set('tags_input', 'Vue.js, JavaScript')
        ->call('save');

    $post->refresh();
    expect($post->tags->pluck('name')->toArray())->toEqualCanonicalizing(['Vue.js', 'JavaScript']);
});

it('removes all tags when input is cleared', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $post->attachTags(['Laravel', 'PHP']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('tags_input', '')
        ->call('save');

    $post->refresh();
    expect($post->tags)->toHaveCount(0);
});

it('filters posts by tag on the index', function (): void {
    $user = User::factory()->create();

    $laravelPost = Post::factory()->for($user)->create(['title' => 'Laravel Post']);
    $laravelPost->attachTags(['Laravel']);

    $phpPost = Post::factory()->for($user)->create(['title' => 'PHP Post']);
    $phpPost->attachTags(['PHP']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('tagFilter', 'Laravel')
        ->assertSee('Laravel Post')
        ->assertDontSee('PHP Post');
});

it('displays tags as badges on the index page', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $post->attachTags(['Laravel', 'Testing']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->assertSee('Laravel')
        ->assertSee('Testing');
});
