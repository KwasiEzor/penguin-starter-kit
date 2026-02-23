<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\RegisterForm;
use App\Support\Toast;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component that handles new user registration.
 *
 * Delegates account creation to the RegisterForm object, displays a
 * success toast, and redirects the newly registered user to the dashboard.
 */
#[Layout('components.layouts.auth')]
final class Register extends Component
{
    public RegisterForm $form;

    /**
     * Create a new user account using the submitted registration form data.
     *
     * @return void
     */
    public function register(): void
    {
        $this->form->register();

        Toast::success('Your account has been created successfully!');

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Render the registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.register');
    }
}
