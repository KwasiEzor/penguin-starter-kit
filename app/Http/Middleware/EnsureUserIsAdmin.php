<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\PermissionEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that restricts access to routes requiring administrator privileges.
 *
 * Checks whether the authenticated user has the AdminAccess permission.
 * If the user lacks admin access, the request is aborted with a 403 Forbidden response.
 */
final class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Verifies the authenticated user has the AdminAccess permission.
     * Aborts with 403 if the user is not an admin.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Closure  $next  The next middleware or request handler
     * @return Response The HTTP response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasPermissionTo(PermissionEnum::AdminAccess)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
