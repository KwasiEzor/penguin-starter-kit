<?php

/**
 * Tests for the password confirmation screen.
 *
 * Verifies that the confirm-password page renders correctly, that a valid
 * password is accepted and redirects to the dashboard, and that an invalid
 * password produces a validation error.
 */

use App\Livewire\Auth\ConfirmPassword;
use App\Models\User;
use Livewire\Livewire;

it('renders the confirm password page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('password.confirm'))
        ->assertOk()
        ->assertSeeLivewire(ConfirmPassword::class);
});

it('confirms password with valid password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(ConfirmPassword::class)
        ->set('password', 'password')
        ->call('confirmPassword')
        ->assertRedirect(route('dashboard'));
});

it('fails with invalid password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(ConfirmPassword::class)
        ->set('password', 'wrong-password')
        ->call('confirmPassword')
        ->assertHasErrors('password');
});
