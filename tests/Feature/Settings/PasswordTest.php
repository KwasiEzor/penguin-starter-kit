<?php

use App\Livewire\Settings\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

it('renders the password settings component', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Password::class)
        ->assertOk()
        ->assertSee('Update password');
});

it('updates the user password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Password::class)
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword')
        ->assertHasNoErrors();

    $user->refresh();
    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

it('fails with wrong current password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Password::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword')
        ->assertHasErrors('current_password');
});

it('fails when passwords do not match', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Password::class)
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'different-password')
        ->call('updatePassword')
        ->assertHasErrors('password');
});
