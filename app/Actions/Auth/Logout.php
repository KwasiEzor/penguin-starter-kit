<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Support\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout
{
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Toast::success('You have been logged out successfully.');

        return redirect()->route('home');
    }
}
