<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('uploads an avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

    Livewire::test(Profile::class)
        ->set('avatar', $file)
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->getFirstMediaUrl('avatar'))->not->toBeEmpty();
});

it('validates avatar is an image', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

    Livewire::test(Profile::class)
        ->set('avatar', $file)
        ->assertHasErrors(['avatar']);
});

it('validates avatar max size', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('large.jpg')->size(3000);

    Livewire::test(Profile::class)
        ->set('avatar', $file)
        ->assertHasErrors(['avatar']);
});

it('removes an avatar', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $user->addMedia(UploadedFile::fake()->image('avatar.jpg', 200, 200))
        ->toMediaCollection('avatar');

    $this->actingAs($user);

    expect($user->getFirstMediaUrl('avatar'))->not->toBeEmpty();

    Livewire::test(Profile::class)
        ->call('removeAvatar');

    $user->refresh();
    expect($user->getFirstMediaUrl('avatar'))->toBeEmpty();
});
