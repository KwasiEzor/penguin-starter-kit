# Security

Security measures implemented in Penguin Starter Kit.

## Encryption at Rest

All sensitive keys are encrypted using Laravel's `Crypt::encryptString()`:

- Stripe secret key and webhook secret
- AI API keys (per-user and global)
- Social authentication secrets

## Rate Limiting

| Route Group | Max Requests | Window |
|---|---|---|
| API (`/api/*`) | 60 | 1 minute |
| Login | 5 | 1 minute |
| Registration | 3 | 1 minute |
| Password Reset | 3 | 1 minute |

Rate limits are configured in `AppServiceProvider`.

## CSRF Protection

All web forms include CSRF protection via Laravel's middleware.

## Authorization

- **PostPolicy** — enforces ownership and role-based access for posts
- **AiAgentPolicy** — enforces ownership and admin access for AI agents
- **EnsureUserIsAdmin** middleware — guards all `/admin/*` routes
- **EnsurePaymentsEnabled** middleware — gates payment routes when disabled

## Form Request Validation

API endpoints use dedicated Form Request classes (`StorePostRequest`, `UpdatePostRequest`) for server-side validation.

## N+1 Query Prevention

`Model::preventLazyLoading()` is enabled in development mode to catch N+1 queries early. In production, lazy loading violations are logged instead of throwing exceptions.

## Security Audits

Weekly automated security audits via GitHub Actions (`security.yml`):
- Composer dependency audit
- npm dependency audit
- Runs on push, PR, and weekly schedule (Monday 8:00 UTC)

## Health Monitoring

Application health dashboard at `/admin/health` powered by Spatie Laravel Health:

| Check | Description |
|---|---|
| Optimized App | Caches are warmed |
| Debug Mode | `APP_DEBUG` is false in production |
| Environment | `APP_ENV` is set correctly |
| Database | Database is reachable |

## CSS Injection Prevention

The theme system validates all user-provided values:
- Hex color validation
- CSS value sanitization
- No arbitrary CSS execution
