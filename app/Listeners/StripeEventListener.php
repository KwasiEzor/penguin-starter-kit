<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        if (($payload['type'] ?? '') === 'checkout.session.completed') {
            $this->handleCheckoutSessionCompleted($payload['data']['object'] ?? []);
        }
    }

    protected function handleCheckoutSessionCompleted(array $session): void
    {
        if (($session['mode'] ?? '') !== 'payment') {
            return;
        }

        $stripeCustomerId = $session['customer'] ?? null;
        if (! $stripeCustomerId) {
            return;
        }

        $user = User::where('stripe_id', $stripeCustomerId)->first();
        if (! $user) {
            return;
        }

        $productId = $session['metadata']['product_id'] ?? null;
        $product = $productId ? Product::find($productId) : null;

        Order::updateOrCreate(
            ['stripe_checkout_session_id' => $session['id']],
            [
                'user_id' => $user->id,
                'product_id' => $product?->id,
                'stripe_payment_intent_id' => $session['payment_intent'] ?? null,
                'amount' => $session['amount_total'] ?? 0,
                'currency' => $session['currency'] ?? 'usd',
                'status' => 'completed',
            ],
        );
    }
}
