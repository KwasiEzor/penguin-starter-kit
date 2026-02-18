<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class CheckoutCancel extends Component
{
    public function render()
    {
        return view('livewire.checkout-cancel');
    }
}
