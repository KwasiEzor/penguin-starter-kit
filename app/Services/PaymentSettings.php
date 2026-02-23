<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;

/**
 * Service for managing Stripe payment configuration and credentials.
 *
 * Retrieves payment settings from the database and falls back to
 * application config values. Handles decryption of sensitive keys
 * and configures the Stripe SDK at runtime.
 */
class PaymentSettings
{
    /**
     * Determine whether payments are enabled in the application settings.
     *
     * @return bool True if payments are enabled.
     */
    public function isEnabled(): bool
    {
        return Setting::paymentsEnabled();
    }

    /**
     * Retrieve the Stripe publishable key.
     *
     * Returns the key from database settings if available, otherwise
     * falls back to the cashier config value.
     *
     * @return string|null The Stripe publishable key, or null if not configured.
     */
    public function getStripeKey(): ?string
    {
        return Setting::get('payments.stripe_key') ?: config('cashier.key');
    }

    /**
     * Retrieve the decrypted Stripe secret key.
     *
     * Attempts to decrypt the stored secret from database settings.
     * Falls back to the cashier config value if not found or decryption fails.
     *
     * @return string|null The decrypted Stripe secret key, or null if not configured.
     */
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

    /**
     * Retrieve the decrypted Stripe webhook secret.
     *
     * Attempts to decrypt the stored webhook secret from database settings.
     * Falls back to the cashier webhook config value if not found or decryption fails.
     *
     * @return string|null The decrypted Stripe webhook secret, or null if not configured.
     */
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

    /**
     * Configure the Stripe SDK and cashier config with the resolved credentials.
     *
     * Sets the publishable key, secret key, and webhook secret in the
     * application config and initializes the Stripe API client.
     *
     * @return void
     */
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
