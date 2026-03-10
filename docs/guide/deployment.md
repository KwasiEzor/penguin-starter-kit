# Deployment

## Production Optimization

Run these commands before deploying to production:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan icons:cache
npm run build
```

## Cache Headers

Configure your web server for optimal static asset caching.

### Nginx

```nginx
location / {
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
    add_header Pragma "no-cache";
}
```

### Apache

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
</IfModule>

Header set Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0"
Header set Pragma "no-cache"
```

## Stripe Webhooks

For production Stripe integration:

```bash
# Set your webhook endpoint in the Stripe dashboard to:
# https://your-domain.com/stripe/webhook

# Or use Stripe CLI for local testing:
stripe listen --forward-to localhost:8000/stripe/webhook
```

## Staying Updated

As a starter kit, this project is meant to be the *beginning* of your application. Tools to help you stay current:

### Dependabot

Pre-configured to keep Composer, npm, and GitHub Actions dependencies updated weekly via automated PRs. Patch updates are auto-merged.

### Release Drafter

Automatically handles versioning and changelogs when you merge PRs to `main`.

### Upstream Sync

Pull in new features or security fixes from the source:

```bash
git remote add upstream https://github.com/kwasiezor/penguin-starter-kit.git
git fetch upstream
git merge upstream/main --allow-unrelated-histories
```

## Environment Checklist

Before going to production, ensure:

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` set to your domain
- [ ] Database configured (MySQL/PostgreSQL recommended)
- [ ] Mail driver configured
- [ ] Queue driver set (Redis/database recommended)
- [ ] Stripe webhook secret configured
- [ ] All caches warmed (config, route, view, event, icons)
- [ ] Assets built with `npm run build`
