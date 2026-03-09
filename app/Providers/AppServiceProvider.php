<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\StripeEventListener;
use App\Models\Setting;
use App\Services\PaymentSettings;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Facades\Health;

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
     */
    public function boot(): void
    {
        // Prevent N+1 queries in development
        if (config('app.debug')) {
            Model::preventLazyLoading(! app()->isProduction());
            Model::preventAccessingMissingAttributes(! app()->isProduction());
            Model::preventSilentlyDiscardingAttributes(! app()->isProduction());

            // Log N+1 queries instead of throwing in production
            Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
                Log::warning('N+1 query detected', [
                    'model' => get_class($model),
                    'relation' => $relation,
                ]);
            });
        }

        if (Setting::paymentsEnabled()) {
            app(PaymentSettings::class)->configureStripe();
        }

        Event::listen(WebhookReceived::class, StripeEventListener::class);

        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            DatabaseCheck::new(),
        ]);

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });
    }
}
