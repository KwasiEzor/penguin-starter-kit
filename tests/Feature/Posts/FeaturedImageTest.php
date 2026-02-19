<?php

use App\Livewire\Posts\Create;
use App\Livewire\Posts\Edit;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('creates a post with a featured image', function (): void {
    Storage::fake('public');

    $user = User::factory()->create();

    $file = UploadedFile::fake()->image('featured.jpg', 800, 600);

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('title', 'Post With Image')
        ->set('body', 'Content with image.')
        ->set('status', 'draft')
        ->set('featured_image', $file)
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'Post With Image')->first();
    expect($post)->not->toBeNull();
    expect($post->getFirstMediaUrl('featured_image'))->not->toBeEmpty();
});

it('uploads a featured image on edit', function (): void {
    Storage::fake('public');

    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $file = UploadedFile::fake()->image('new-image.jpg', 800, 600);

    Livewire::actingAs($user)
        ->test(Edit::class, ['post' => $post])
        ->set('featured_image', $file)
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post->refresh();
    expect($post->getFirstMediaUrl('featured_image'))->not->toBeEmpty();
});

it('removes a featured image', function (): void {
    Storage::fake('public');

    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $post->addMedia(UploadedFile::fake()->image('featured.jpg', 800, 600))
        ->toMediaCollection('featured_image');

    expect($post->getFirstMediaUrl('featured_image'))->not->toBeEmpty();

    Livewire::actingAs($user)
        ->test(Edit::class, ['post' => $post])
        ->call('removeFeaturedImage');

    $post->refresh();
    expect($post->getFirstMediaUrl('featured_image'))->toBeEmpty();
});

it('validates featured image is an image file', function (): void {
    $user = User::factory()->create();

    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('title', 'Post')
        ->set('body', 'Content')
        ->set('status', 'draft')
        ->set('featured_image', $file)
        ->call('save')
        ->assertHasErrors(['featured_image']);
});
