<?php

use App\Models\User;

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});

it('flashes a toast message on logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'));

    expect(session('notify'))->toHaveKey('type', 'success');
});
