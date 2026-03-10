# Payments

Fully feature-flagged payment system powered by [Laravel Cashier](https://laravel.com/docs/billing).

## Features

- **Feature-flagged** — admin toggles payments on/off; all payment routes return 404 when disabled, UI elements are hidden
- **Stripe key management** — publishable key, secret key (encrypted at rest), webhook secret, and currency stored in the database
- **Subscription plans** — name, description, price, billing interval (monthly/yearly), feature list, Stripe price ID, active/featured toggles
- **One-time products** — name, description, price, Stripe price ID, active toggle
- **Checkout** via Stripe Checkout Sessions for both subscriptions and one-time purchases
- **Billing portal** — users manage subscriptions through Stripe's Customer Portal
- **Order tracking** — purchase records with status (pending, completed, failed, refunded)
- **Webhook handling** — listens for `checkout.session.completed` to record one-time purchases
- **Pricing page** — public-facing page displaying all active plans and products

## Configuration

### Via Admin Panel (Recommended)

Go to **Admin > Payments** to:
- Toggle payments on/off
- Enter Stripe publishable key, secret key, and webhook secret
- Set the billing currency
- Create and manage subscription plans and one-time products

### Via Environment Variables

```ini
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=usd
```

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/pricing` | `pricing` | Pricing page |
| GET | `/billing` | `billing` | Billing management |
| GET | `/checkout/success` | `checkout.success` | Post-checkout success |
| GET | `/checkout/cancel` | `checkout.cancel` | Post-checkout cancellation |

::: warning
All payment routes return 404 when the payment feature is disabled. The `EnsurePaymentsEnabled` middleware handles this gating.
:::

## Webhook Setup

For production:

```bash
# Set your webhook endpoint in the Stripe dashboard to:
# https://your-domain.com/stripe/webhook

# For local testing:
stripe listen --forward-to localhost:8000/stripe/webhook
```

The `StripeEventListener` handles `checkout.session.completed` events to record one-time purchases.
