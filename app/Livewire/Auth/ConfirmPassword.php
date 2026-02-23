<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component that handles password confirmation before accessing protected areas.
 *
 * Prompts the authenticated user to re-enter their password and stores
 * a confirmation timestamp in the session upon successful validation.
 */
#[Layout('components.layouts.auth')]
final class ConfirmPassword extends Component
{
    public string $password = '';

    /**
     * Validate the user's password and mark the session as password-confirmed.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Render the password confirmation view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.confirm-password');
    }
}
