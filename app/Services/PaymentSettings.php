<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;

class PaymentSettings
{
    public function isEnabled(): bool
    {
        return Setting::paymentsEnabled();
    }

    public function getStripeKey(): ?string
    {
        return Setting::get('payments.stripe_key') ?: config('cashier.key');
    }

    public function getStripeSecret(): ?string
    {
        $encrypted = Setting::get('payments.stripe_secret');

        if ($encrypted) {
            try {
                return Crypt::decryptString($encrypted);
            } catch (\Exception) {
                return null;
            }
        }

        return config('cashier.secret');
    }

    public function getWebhookSecret(): ?string
    {
        $encrypted = Setting::get('payments.stripe_webhook_secret');

        if ($encrypted) {
            try {
                return Crypt::decryptString($encrypted);
            } catch (\Exception) {
                return null;
            }
        }

        return config('cashier.webhook.secret');
    }

    public function configureStripe(): void
    {
        $key = $this->getStripeKey();
        $secret = $this->getStripeSecret();
        $webhookSecret = $this->getWebhookSecret();

        if ($key) {
            config(['cashier.key' => $key]);
        }

        if ($secret) {
            config(['cashier.secret' => $secret]);
            Stripe::setApiKey($secret);
        }

        if ($webhookSecret) {
            config(['cashier.webhook.secret' => $webhookSecret]);
        }
    }
}
