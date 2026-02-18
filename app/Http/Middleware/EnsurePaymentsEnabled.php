<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsurePaymentsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Setting::paymentsEnabled()) {
            abort(404);
        }

        return $next($request);
    }
}
