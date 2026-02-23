<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that restricts access to payment-related routes when payments are disabled.
 *
 * Checks the application settings to determine if the payment system is enabled.
 * If payments are disabled, the request is aborted with a 404 response.
 */
final class EnsurePaymentsEnabled
{
    /**
     * Handle an incoming request.
     *
     * Checks if payments are enabled in application settings. If not,
     * aborts with a 404 to hide payment routes entirely.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Closure  $next  The next middleware or request handler
     * @return Response The HTTP response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Setting::paymentsEnabled()) {
            abort(404);
        }

        return $next($request);
    }
}
