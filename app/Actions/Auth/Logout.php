<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Support\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles user logout by invalidating the session and redirecting to home.
 *
 * This invokable action logs the user out, invalidates their session,
 * regenerates the CSRF token, and redirects to the home page with a
 * success toast message.
 */
class Logout
{
    /**
     * Log the user out and redirect to the home page.
     *
     * @param  Request  $request  The incoming HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirect to the home route
     */
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Toast::success('You have been logged out successfully.');

        return redirect()->route('home');
    }
}
