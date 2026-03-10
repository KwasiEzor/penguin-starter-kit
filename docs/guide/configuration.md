# Configuration

## Environment Variables

Add the following to your `.env` file to enable optional features:

```ini
# ─── App ───────────────────────────────────────────────
APP_NAME="My Application"
APP_URL=http://localhost

# ─── Stripe Payments ───────────────────────────────────
# (or configure via Admin > Payments in the UI)
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=usd

# ─── Real-time Broadcasting (Laravel Reverb) ──────────
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_APP_ID=your-app-id
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

# ─── AI Providers ─────────────────────────────────────
# (or configure via Admin > AI Settings / User Settings)
OPENAI_API_KEY=sk-...
ANTHROPIC_API_KEY=sk-ant-...
GEMINI_API_KEY=...

# ─── Mail ─────────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS="hello@example.com"
```

::: tip
Most settings (payments, AI keys, site name) can also be configured from the admin panel without editing `.env` files.
:::

## Database Configuration

SQLite is the default database for zero-config setup. To switch to MySQL or PostgreSQL, update your `.env`:

### MySQL

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penguin
DB_USERNAME=root
DB_PASSWORD=
```

### PostgreSQL

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=penguin
DB_USERNAME=postgres
DB_PASSWORD=
```

After changing the database driver, run migrations:

```bash
php artisan migrate
```

## Development Server

```bash
# Option 1: Start all services at once
composer dev

# Option 2: Start services individually
php artisan serve              # Laravel server
npm run dev                    # Vite hot-reloading
php artisan queue:listen       # Queue worker
php artisan reverb:start       # WebSocket server (optional)
php artisan pail               # Log viewer (optional)
```

## Configuration Files

| File | Purpose |
|---|---|
| `config/ai.php` | AI provider configuration |
| `config/health.php` | Health check configuration |
| `config/theme.php` | Font families, radius, speed, easing, shadows |
| `config/cashier.php` | Stripe/Cashier configuration |
| `config/permission.php` | Spatie Permission settings |
| `config/media-library.php` | Spatie Media Library settings |
