<?php

/**
 * Tests for the logout functionality.
 *
 * Verifies that an authenticated user can log out, is redirected to the
 * home page, becomes a guest, and receives a success toast flash message.
 */

use App\Models\User;

it('logs out an authenticated user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});

it('flashes a toast message on logout', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'));

    expect(session('notify'))->toHaveKey('type', 'success');
});
