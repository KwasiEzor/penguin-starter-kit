<?php

namespace App\Providers;

use App\Listeners\StripeEventListener;
use App\Models\Setting;
use App\Services\PaymentSettings;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Setting::paymentsEnabled()) {
            app(PaymentSettings::class)->configureStripe();
        }

        Event::listen(WebhookReceived::class, StripeEventListener::class);
    }
}
