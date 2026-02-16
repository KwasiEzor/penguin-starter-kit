<?php

use App\Livewire\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Livewire\Livewire;

it('renders the forgot password page', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSeeLivewire(ForgotPassword::class);
});

it('sends a password reset link', function () {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});
