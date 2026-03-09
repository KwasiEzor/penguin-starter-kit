# Contributing to Penguin Starter Kit

Thank you for considering contributing! This guide will help you get started.

## Development Setup

1. Fork the repository and clone it locally
2. Run the setup script:
   ```bash
   composer setup
   ```
3. Start the development server:
   ```bash
   composer dev
   ```

## Coding Standards

This project enforces strict code quality standards:

- **PHP Style**: [Laravel Pint](https://laravel.com/docs/pint) - run `composer lint`
- **Static Analysis**: [PHPStan](https://phpstan.org/) at level 6 - run `composer analyse`
- **Refactoring**: [Rector](https://getrector.com/) - run `composer rector:check`
- **Type Coverage**: 100% type coverage enforced - run `composer type-coverage`
- **Frontend Formatting**: [Prettier](https://prettier.io/) for Blade, JS, and CSS

Run all checks at once:
```bash
composer check-all
```

## Pull Request Process

1. Create a feature branch from `main`
2. Make your changes with clear, focused commits
3. Ensure all checks pass: `composer check-all`
4. Ensure all tests pass: `composer test`
5. Open a pull request with a clear description of the changes
6. Use labels (`feature`, `fix`, `docs`, etc.) to categorize your PR

## Testing

All new features and bug fixes should include tests. We use [Pest](https://pestphp.com/).

```bash
# Run all tests
composer test

# Run a specific test file
php artisan test --filter=ExampleTest
```

## Reporting Issues

- Use the [GitHub Issues](https://github.com/kwasiezor/penguin-starter-kit/issues) tracker
- Include steps to reproduce, expected behavior, and actual behavior
- Include your PHP version, Laravel version, and OS
