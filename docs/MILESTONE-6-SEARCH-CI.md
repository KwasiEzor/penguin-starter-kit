# Milestone 6: Global Search and CI/CD

## Summary

Added a Cmd+K spotlight search component for navigating pages and searching posts, a GitHub Actions CI pipeline for automated testing and code style checks, and a Pint configuration file.

## What Was Added

### Spotlight Search (`Cmd+K`)
- **SpotlightSearch** (`app/Livewire/SpotlightSearch.php`)
  - Opens with `Cmd+K` (or `Ctrl+K`), closes with `Escape`
  - Searches posts by title and body (minimum 2 characters, debounced)
  - Shows matching navigation pages (Dashboard, Posts, Settings)
  - Results scoped to authenticated user's posts only
  - Click results to navigate directly
  - Clean modal overlay with keyboard shortcut hints

### Layout Integration
- Spotlight search added to both **sidebar** and **navbar** layout variants
- Only rendered for authenticated users

### GitHub Actions CI (`.github/workflows/ci.yml`)
Two parallel jobs:
1. **tests** — PHP 8.4, SQLite, runs `php artisan test`
2. **code-style** — runs `vendor/bin/pint --test`

Triggers on push to `main` and pull requests to `main`.

### Pint Configuration (`.pint.json`)
- Laravel preset
- No spaces around concatenation
- Array and method chaining indentation
- Trailing commas in multiline arguments

## Tests Added (6 new tests)

- `tests/Feature/SpotlightSearchTest.php`
  - Renders component
  - Searches posts by title
  - Shows navigation pages
  - Shows no results message
  - Scopes to current user's posts
  - Close resets state

**Total: 136 tests passing (287 assertions)**
