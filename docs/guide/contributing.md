# Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-feature`
3. Ensure all quality checks pass: `composer check-all`
4. Commit your changes with a descriptive message
5. Push to your branch: `git push origin feature/my-feature`
6. Open a Pull Request

## PR Requirements

Please ensure your PR:

- Passes all CI checks (tests, Pint, PHPStan, Rector, type coverage, Prettier)
- Includes tests for new features
- Updates documentation as needed

## Development Setup

```bash
git clone https://github.com/kwasiezor/penguin-starter-kit.git
cd penguin-starter-kit
composer setup
npm install && npm run dev
```

## Quality Checks

Before submitting, run the full quality suite:

```bash
composer check-all
```

This runs: Laravel Pint, PHPStan, Rector, type coverage, Prettier, and the full test suite.

## Support

- **Issues**: [github.com/kwasiezor/penguin-starter-kit/issues](https://github.com/kwasiezor/penguin-starter-kit/issues)
- **Source**: [github.com/kwasiezor/penguin-starter-kit](https://github.com/kwasiezor/penguin-starter-kit)
