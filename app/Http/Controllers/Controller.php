<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Base controller for the application.
 *
 * Provides authorization capabilities via the AuthorizesRequests trait.
 * All application controllers should extend this class.
 */
abstract class Controller
{
    use AuthorizesRequests;
}
