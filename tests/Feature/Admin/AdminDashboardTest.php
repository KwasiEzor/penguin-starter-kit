<?php

use App\Models\User;

it('allows admin users to access admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Admin Dashboard');
});

it('forbids non-admin users from accessing admin dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('redirects guests to login', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('displays stats on admin dashboard', function () {
    $admin = User::factory()->admin()->create();
    User::factory(3)->create();
    \App\Models\Post::factory(5)->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSee('Total Users')
        ->assertSee('Total Posts');
});
