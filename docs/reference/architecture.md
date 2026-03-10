# Architecture

Key architectural decisions and patterns in Penguin Starter Kit.

## Livewire 4

All server-side reactivity is handled by Livewire. Alpine.js is imported from Livewire's ESM bundle to avoid double initialization.

## Livewire Form Objects

`LoginForm` and `RegisterForm` encapsulate validation rules and form logic, keeping component classes clean.

## Invokable Actions

Single-responsibility action classes (e.g., `Logout`) follow the invokable pattern for non-component logic.

## PenguinUI Tokens

Semantic token names (`surface`, `primary`, `on-surface`, `outline`) are used instead of raw colors for consistent theming across light and dark modes.

## User Model

The `User` model has a `hashed` cast on `password`, so never manually call `Hash::make()` when creating users.

## Media Library

Spatie Media Library handles all file uploads with `singleFile()` collections, so uploading a new file automatically replaces the old one.

## Settings Model

The `Setting` model uses `Cache::rememberForever` with automatic invalidation on update for zero-cost reads.

## Payment System

Fully feature-flagged — toggling payments off makes all payment routes return 404 and hides UI elements. The `EnsurePaymentsEnabled` middleware handles this.

## Encryption

Stripe secrets and AI API keys are encrypted at rest using Laravel's `Crypt::encryptString()`.

## Broadcasting

Real-time broadcasting uses per-user private channels, not shared public channels, ensuring notifications reach only intended recipients.

## AI Key Resolution

Per-user keys take priority over admin-configured global keys, all encrypted at rest. The `AiService` handles this layered resolution.

## Categories

Categories use a polymorphic `categorizables` table, making them attachable to any model beyond just posts.

## Theme System

The `ThemeService` generates CSS at runtime from database-stored overrides, validated and sanitized before output to prevent CSS injection.

## Website Settings

Branding, SEO, and analytics settings are fully admin-configurable from **Admin > Website Settings** without code changes. The `WebsiteService` handles retrieval with caching.

## Coding Conventions

- **Strict types** declared in all PHP files
- **`final` classes** on all Livewire components
- **Enums** for roles (`RoleEnum`), permissions (`PermissionEnum`), and AI providers (`AiProviderEnum`)
- **N+1 query prevention** via `Model::preventLazyLoading()` in development
