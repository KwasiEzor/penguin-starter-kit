<?php

/**
 * Tests for the admin dashboard feature.
 *
 * Verifies that admin users can access the dashboard and view stats,
 * non-admin users are forbidden, and unauthenticated guests are
 * redirected to the login page.
 */

use App\Models\User;

it('allows admin users to access admin dashboard', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Admin Dashboard');
});

it('forbids non-admin users from accessing admin dashboard', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('redirects guests to login', function (): void {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('displays stats on admin dashboard', function (): void {
    $admin = User::factory()->admin()->create();
    User::factory(3)->create();
    \App\Models\Post::factory(5)->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSee('Total Users')
        ->assertSee('Total Posts');
});
