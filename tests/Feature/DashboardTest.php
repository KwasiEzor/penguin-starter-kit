<?php

/**
 * Tests for the dashboard page.
 *
 * Ensures the dashboard renders for authenticated users and that
 * unauthenticated guests are redirected to the login page.
 */

use App\Livewire\Dashboard;
use App\Models\User;

it('renders the dashboard page for authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSeeLivewire(Dashboard::class);
});

it('redirects guests to login', function (): void {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});
