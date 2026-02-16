<?php

use App\Livewire\Auth\Register;
use App\Models\User;
use Livewire\Livewire;

it('renders the register page', function () {
    $this->get(route('register'))
        ->assertOk()
        ->assertSeeLivewire(Register::class);
});

it('registers a new user', function () {
    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    $this->assertAuthenticated();
});

it('fails with duplicate email', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'existing@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors('form.email');
});
