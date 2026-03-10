# Testing

The test suite includes **290+ tests** with **630+ assertions** covering every major feature.

## Running Tests

```bash
# Run the full test suite
php artisan test

# Run tests in parallel
php artisan test --parallel

# Run a specific test file
php artisan test tests/Feature/Auth/AuthFlowTest.php

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage

# Type coverage check
vendor/bin/pest --type-coverage --memory-limit=512M --min=100
```

## Test Coverage

| Area | What's Tested |
|---|---|
| **Auth** | Register, login, logout, forgot/reset password, email verification, password confirmation |
| **Posts** | CRUD, tags, categories, featured images, rich text, SEO fields, data table filters |
| **AI Agents** | CRUD, execution tracking, API key management, visibility controls, authorization |
| **Categories** | CRUD, polymorphic relationships, post integration, admin management |
| **Admin** | Dashboard stats, user management, role management, category management, AI settings, payment settings, plan/product CRUD |
| **Payments** | Pricing page visibility, billing page, feature flag behavior |
| **API** | Sanctum-authenticated post endpoints, form request validation |
| **Components** | Button, input, modal, separator, textarea, select, toggle, badge, card, avatar, alert, tabs, table, file upload |
| **Settings** | Profile update, password change, avatar upload, AI API keys, API tokens, account deletion |
| **Notifications** | Notification center, broadcasting events |
| **Spotlight Search** | Post search, page search, keyboard shortcut |
| **Models** | User, Post, AiAgent, Category relationships and scopes |

## Code Quality Tools

```bash
# Run all quality checks at once
composer quality

# Individual tools
composer lint          # Laravel Pint (fix)
composer lint:check    # Laravel Pint (check only)
composer analyse       # PHPStan static analysis
composer rector        # Rector automated refactoring (fix)
composer rector:check  # Rector (check only)
composer type-coverage # Pest type coverage (min 100%)

# Frontend formatting
npm run format         # Prettier (fix)
npm run format:check   # Prettier (check only)

# Run absolutely everything
composer check-all     # Pint + PHPStan + Rector + type coverage + Prettier + tests
```

## Coding Standards

- **Strict types** declared in all PHP files
- **`final` classes** on all Livewire components
- **Invokable actions** for single-responsibility classes
- **Livewire Form Objects** for validation and form logic
- **Enums** for roles, permissions, and AI providers
- **N+1 query prevention** in development mode
- **Lazy loading violations** logged in production
