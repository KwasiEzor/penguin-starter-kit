# CI/CD

GitHub Actions workflows for continuous integration and deployment.

## CI Pipeline (`ci.yml`)

Runs on every push and PR to `main`. 6 parallel jobs:

| Job | Description |
|---|---|
| **Tests** | PHP 8.4, SQLite, full Pest test suite with parallel execution |
| **Code Style** | Laravel Pint in check mode |
| **Static Analysis** | PHPStan with 512MB memory limit |
| **Rector** | Automated refactoring checks (dry run) |
| **Type Coverage** | Pest type coverage (minimum 100%) |
| **Prettier** | Blade, JS, and CSS formatting checks |

## Security Audit (`security.yml`)

- Runs on push, PR, and **weekly schedule** (Monday 8:00 UTC)
- Audits both Composer and npm dependencies for known vulnerabilities

## Release Drafter (`release-drafter.yml`)

- Automatically drafts releases when PRs are merged to `main`
- Categorizes changes: Features, Bug Fixes, Dependencies, Documentation, CI/CD
- Semantic versioning: major/minor/patch based on PR labels

## Dependabot Auto-Merge (`dependabot-auto-merge.yml`)

- Automatically approves and squash-merges patch-level dependency updates
- Keeps dependencies current with minimal manual effort

## Dependabot Configuration

| Ecosystem | Frequency | Max Open PRs |
|---|---|---|
| Composer | Weekly | 10 |
| npm | Weekly | 10 |
| GitHub Actions | Monthly | — |

## Running Checks Locally

```bash
# Run the same checks as CI
composer check-all

# Individual checks
composer lint:check     # Pint
composer analyse        # PHPStan
composer rector:check   # Rector
composer type-coverage  # Type coverage
npm run format:check    # Prettier
php artisan test        # Tests
```
