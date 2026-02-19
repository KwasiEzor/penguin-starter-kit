<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\HasToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Billing extends Component
{
    use HasToast;

    public function redirectToPortal(): mixed
    {
        $user = auth()->user();

        if (! $user->hasStripeId()) {
            $this->toastError('No billing account found. Please make a purchase first.');

            return null;
        }

        return redirect($user->billingPortalUrl(route('billing')));
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = auth()->user();

        return view('livewire.billing', [
            'subscription' => $user->subscription('default'),
            'orders' => $user->orders()->with('product')->latest()->take(10)->get(),
            'hasStripeId' => $user->hasStripeId(),
        ]);
    }
}
