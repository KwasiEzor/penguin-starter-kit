<?php

/**
 * Tests for the forgot-password functionality.
 *
 * Ensures the forgot-password page renders correctly and that submitting
 * a valid email address dispatches a password reset link notification.
 */

use App\Livewire\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

it('renders the forgot password page', function (): void {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSeeLivewire(ForgotPassword::class);
});

it('sends a password reset link', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});
