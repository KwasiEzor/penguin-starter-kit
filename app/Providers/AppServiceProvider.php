<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\StripeEventListener;
use App\Models\Setting;
use App\Services\PaymentSettings;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

/**
 * Application service provider responsible for bootstrapping core services.
 *
 * Configures Stripe payment integration when payments are enabled
 * and registers event listeners for incoming Stripe webhooks.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Configures Stripe credentials if payments are enabled and registers
     * the Stripe webhook event listener.
     *
     * @return void
     */
    public function boot(): void
    {
        if (Setting::paymentsEnabled()) {
            app(PaymentSettings::class)->configureStripe();
        }

        Event::listen(WebhookReceived::class, StripeEventListener::class);
    }
}
