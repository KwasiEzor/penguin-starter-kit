<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

it('registers a user and then that user can log in', function (): void {
    // Step 1: Register
    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('register')
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    $this->assertAuthenticated();

    // Verify the password is correct in DB
    $user = User::where('email', 'test@example.com')->first();
    expect(Hash::check('password123', $user->password))->toBeTrue('Password should be verifiable after registration');

    // Step 2: Logout
    auth()->logout();
    $this->assertGuest();

    // Step 3: Login with same credentials
    Livewire::test(Login::class)
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password123')
        ->call('login')
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('cannot register with a password that is too short', function (): void {
    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'short')
        ->set('form.password_confirmation', 'short')
        ->call('register')
        ->assertHasErrors('form.password');

    $this->assertGuest();
});

it('cannot register with mismatched passwords', function (): void {
    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'different123')
        ->call('register')
        ->assertHasErrors('form.password');

    $this->assertGuest();
});

it('cannot register with empty name', function (): void {
    Livewire::test(Register::class)
        ->set('form.name', '')
        ->set('form.email', 'test@example.com')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors('form.name');
});

it('cannot register with invalid email', function (): void {
    Livewire::test(Register::class)
        ->set('form.name', 'Test User')
        ->set('form.email', 'not-an-email')
        ->set('form.password', 'password123')
        ->set('form.password_confirmation', 'password123')
        ->call('register')
        ->assertHasErrors('form.email');
});

it('login works with factory user', function (): void {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('form.email', $user->email)
        ->set('form.password', 'password')
        ->call('login')
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('login fails with wrong password', function (): void {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('form.email', $user->email)
        ->set('form.password', 'wrong-password')
        ->call('login')
        ->assertHasErrors('form.email');

    $this->assertGuest();
});

it('login remembers user when remember is checked', function (): void {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('form.email', $user->email)
        ->set('form.password', 'password')
        ->set('form.remember', true)
        ->call('login')
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});
