<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Concerns\HasToast;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component that handles the "forgot password" flow.
 *
 * Accepts an email address, sends a password reset link to the user,
 * and displays a success toast or validation error accordingly.
 */
#[Layout('components.layouts.auth')]
final class ForgotPassword extends Component
{
    use HasToast;

    public string $email = '';

    /**
     * Validate the email address and send a password reset link.
     *
     * @return void
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        $this->toastSuccess('We have emailed your password reset link!');

        session()->flash('status', __($status));
    }

    /**
     * Render the forgot password view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.forgot-password');
    }
}
