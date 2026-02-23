<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component that handles email verification for authenticated users.
 *
 * If the user has not yet verified their email, this component re-sends
 * the verification notification and flashes a status message to the session.
 */
#[Layout('components.layouts.auth')]
final class VerifyEmail extends Component
{
    /**
     * Send an email verification notification to the authenticated user.
     *
     * If the user's email is already verified, redirect to the dashboard instead.
     *
     * @return void
     */
    public function sendVerification(): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Render the email verification view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.verify-email');
    }
}
