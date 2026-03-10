# Authentication

Penguin Starter Kit ships with a complete authentication system built on Livewire 4 with Form Objects.

## Features

- **Login** with email/password, "remember me" option, and rate limiting (5 requests/minute)
- **Registration** with name, email, password, and password confirmation (3 requests/minute)
- **Forgot Password** sends a reset link via email (3 requests/minute)
- **Reset Password** with secure token validation
- **Email Verification** with resend capability
- **Confirm Password** gate for secure areas
- **Logout** with session invalidation and toast notification

## Admin-Configurable Settings

Authentication behavior can be configured from **Admin > Auth Settings**:

| Setting | Description |
|---|---|
| Toggle registration | Enable or disable new user registration |
| Domain whitelist | Restrict registration to specific email domains |
| Email verification | Require email verification after registration |
| Password policy | Minimum length, mixed case, symbols, numbers |
| Session lifetime | Configure session expiration time |
| Social login | Google, GitHub, Facebook OAuth configuration |

## Rate Limiting

| Route | Max Requests | Window |
|---|---|---|
| Login | 5 | 1 minute |
| Registration | 3 | 1 minute |
| Password Reset | 3 | 1 minute |

Rate limits are configured in `AppServiceProvider`:

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
});
```

## Architecture

Authentication is implemented using:

- **Livewire Form Objects** — `LoginForm` and `RegisterForm` encapsulate validation rules
- **Invokable Actions** — `Logout` action follows single-responsibility
- **Middleware** — `EnsureUserIsAdmin` guards admin routes
- **Policies** — `PostPolicy` and `AiAgentPolicy` enforce ownership

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/login` | `login` | Login form |
| GET | `/register` | `register` | Registration form |
| GET | `/forgot-password` | `password.request` | Forgot password form |
| GET | `/reset-password/{token}` | `password.reset` | Reset password form |
| GET | `/verify-email` | `verification.notice` | Email verification notice |
| GET | `/confirm-password` | `password.confirm` | Password confirmation |
| POST | `/logout` | `logout` | Logout action |
