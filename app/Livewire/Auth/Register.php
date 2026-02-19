<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\RegisterForm;
use App\Support\Toast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
final class Register extends Component
{
    public RegisterForm $form;

    public function register(): void
    {
        $this->form->register();

        Toast::success('Your account has been created successfully!');

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.register');
    }
}
