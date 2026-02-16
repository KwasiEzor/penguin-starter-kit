<?php

use App\Livewire\Auth\ResetPassword;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

it('renders the reset password page', function () {
    $this->get(route('password.reset', ['token' => 'test-token']))
        ->assertOk()
        ->assertSeeLivewire(ResetPassword::class);
});

it('resets the password with valid token', function () {
    Event::fake();

    $user = User::factory()->create();

    $token = Password::createToken($user);

    Livewire::test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('resetPassword')
        ->assertRedirect(route('login'));

    $user->refresh();
    expect(Hash::check('new-password', $user->password))->toBeTrue();

    Event::assertDispatched(PasswordReset::class);
});

it('fails with invalid token', function () {
    $user = User::factory()->create();

    Livewire::test(ResetPassword::class, ['token' => 'invalid-token'])
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('resetPassword')
        ->assertHasErrors('email');
});
