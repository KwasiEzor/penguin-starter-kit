<?php

/**
 * Tests for the settings page route and access control.
 *
 * Verifies that the settings page renders for authenticated users
 * and redirects unauthenticated guests to the login page.
 */

use App\Livewire\Settings;
use App\Models\User;

it('renders the settings page for authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('settings'))
        ->assertOk()
        ->assertSeeLivewire(Settings::class);
});

it('redirects guests to login', function (): void {
    $this->get(route('settings'))
        ->assertRedirect(route('login'));
});
