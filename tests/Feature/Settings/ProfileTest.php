<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

it('renders the profile settings component', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertOk()
        ->assertSee('Profile');
});

it('updates the user profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('name', 'Updated Name')
        ->set('email', 'updated@example.com')
        ->call('updateProfile')
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->name)->toBe('Updated Name');
    expect($user->email)->toBe('updated@example.com');
});

it('resets email verification when email changes', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('email', 'newemail@example.com')
        ->call('updateProfile');

    $user->refresh();
    expect($user->email_verified_at)->toBeNull();
});

it('validates profile fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('name', '')
        ->set('email', 'not-an-email')
        ->call('updateProfile')
        ->assertHasErrors(['name', 'email']);
});
