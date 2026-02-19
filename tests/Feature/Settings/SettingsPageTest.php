<?php

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
