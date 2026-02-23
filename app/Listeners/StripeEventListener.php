<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Laravel\Cashier\Events\WebhookReceived;

/**
 * Listens for incoming Stripe webhook events and processes them.
 *
 * Currently handles the checkout.session.completed event to create
 * order records when a customer completes a one-time payment checkout session.
 */
class StripeEventListener
{
    /**
     * Handle the incoming Stripe webhook event.
     *
     * Checks the event type and delegates to the appropriate handler method.
     *
     * @param  WebhookReceived  $event  The webhook event received from Stripe via Laravel Cashier
     * @return void
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        if (($payload['type'] ?? '') === 'checkout.session.completed') {
            $this->handleCheckoutSessionCompleted($payload['data']['object'] ?? []);
        }
    }

    /**
     * Handle a completed checkout session event.
     *
     * Creates or updates an Order record for the completed payment session.
     * Only processes sessions with mode "payment" (one-time payments).
     * Looks up the user by their Stripe customer ID and associates the order
     * with the product specified in the session metadata.
     *
     * @param  array<string, mixed>  $session  The checkout session data from the Stripe payload
     * @return void
     */
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
