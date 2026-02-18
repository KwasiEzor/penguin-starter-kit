<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Concerns\HasToast;
use App\Models\Plan;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class Pricing extends Component
{
    use HasToast;

    public function subscribe(int $planId): mixed
    {
        $plan = Plan::where('is_active', true)->findOrFail($planId);

        if (! $plan->stripe_price_id) {
            $this->toastError('This plan is not configured for checkout yet.');

            return null;
        }

        $user = auth()->user();

        if ($user->subscribed('default')) {
            $this->toastWarning('You already have an active subscription. Visit your billing page to manage it.');

            return null;
        }

        return $user->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
            ])
            ->toArray()['url'] ?? null;
    }

    public function purchase(int $productId): mixed
    {
        $product = Product::where('is_active', true)->findOrFail($productId);

        if (! $product->stripe_price_id) {
            $this->toastError('This product is not configured for checkout yet.');

            return null;
        }

        return auth()->user()->checkout([$product->stripe_price_id => 1], [
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'product_id' => $product->id,
            ],
        ])->toArray()['url'] ?? null;
    }

    public function render()
    {
        return view('livewire.pricing', [
            'plans' => Plan::where('is_active', true)->orderBy('sort_order')->orderBy('price')->get(),
            'products' => Product::where('is_active', true)->orderBy('sort_order')->orderBy('price')->get(),
        ]);
    }
}
