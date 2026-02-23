<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

/**
 * Livewire form object for handling user login authentication.
 *
 * Manages email and password validation, rate limiting of login attempts,
 * and authentication via Laravel's Auth facade.
 */
final class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * Validates rate limiting, attempts authentication, and clears
     * the rate limiter on success. Increments the rate limiter on failure.
     *
     * @return void
     *
     * @throws ValidationException If authentication fails or the user is rate limited.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * Allows up to 5 attempts before locking out. Fires a Lockout event
     * and throws a validation exception when the limit is exceeded.
     *
     * @return void
     *
     * @throws ValidationException If too many login attempts have been made.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Generate the rate limiter throttle key for the current request.
     *
     * Combines the lowercased, transliterated email with the client IP address.
     *
     * @return string The throttle key used for rate limiting.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
