# User Settings

Tabbed settings page with five sections.

## Profile

- Update name and email (resets email verification on change)
- Avatar upload and removal via Spatie Media Library
- Profile information is used across the app (sidebar, navbar, comments)

## Password

- Change password with current password verification
- Password requirements are configured by the admin (minimum length, mixed case, symbols, numbers)

## Appearance

- Light, dark, and system theme picker
- Persisted in `localStorage` for instant loading
- System mode follows OS preference

## AI API Keys

- Manage personal API keys per provider (OpenAI, Anthropic, Gemini)
- All keys encrypted at rest using `Crypt::encryptString()`
- Per-user keys take priority over admin-configured global keys

## API Tokens

- Create named personal access tokens (token shown once on creation)
- View existing tokens with creation date
- Revoke tokens individually
- Tokens are used for [REST API](/features/api) authentication

## Delete Account

- Modal confirmation with password verification
- Permanently deletes the user account and associated data

## Route

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/settings` | `settings` | User settings (all tabs) |
