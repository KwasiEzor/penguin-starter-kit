<?php

use App\Livewire\Dashboard;
use App\Models\User;
use Livewire\Livewire;

it('renders the dashboard page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSeeLivewire(Dashboard::class);
});

it('redirects guests to login', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});
