<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\LoginForm;
use App\Support\Toast;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component that handles user authentication.
 *
 * Validates credentials via the LoginForm object, regenerates the session,
 * displays a success toast, and redirects the user to the intended destination.
 */
#[Layout('components.layouts.auth')]
final class Login extends Component
{
    public LoginForm $form;

    /**
     * Authenticate the user using the submitted login form data.
     *
     * @return void
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        Toast::success('You have successfully logged in!');

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Render the login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.login');
    }
}
