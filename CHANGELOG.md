# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Composer dependency caching in CI workflows
- Release drafter configuration for automated release notes
- Dependabot auto-merge workflow for patch updates
- Security scanning workflow (`composer audit` + `npm audit`)
- `.gitattributes` export-ignore for cleaner Composer distributions
- CONTRIBUTING.md with contributor guidelines
- Tab component keyboard navigation (arrow keys, Home/End)
- Responsive nav link focus-visible styling
- Font CDN `font-display: swap` fallback

### Fixed
- AiService global config key leak under Laravel Octane (keys now restored after execution)
- ThemeService CSS injection via unsanitized color/font/radius values
- Duplicate Composer scripts block (second definition silently overrode the first)
- Wildcard version constraints for `spatie/cpu-load-health-check` and `spatie/security-advisories-health-check`
- PHPStan baseline cleared (all models now have proper `@use HasFactory<Factory>` annotations)
- User model unnecessary fully-qualified class name for Post

### Changed
- Setting model now logs caught `QueryException` instead of silently swallowing it
- ThemeService `json_decode` now validates for JSON errors

### Security
- ThemeService validates hex color format, sanitizes font names, validates numeric CSS values
- AiService isolates per-user API keys to prevent cross-request leakage
