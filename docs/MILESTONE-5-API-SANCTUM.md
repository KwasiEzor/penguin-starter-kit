# Milestone 5: API Layer with Sanctum

## Summary

Added Laravel Sanctum for API authentication, a full REST API for Posts, and a token management UI in settings.

## What Was Added

### Package
- **Laravel Sanctum v4** — installed via Composer with migration and config published

### User Model
- Added `HasApiTokens` trait to User model

### API Routes (`routes/api.php`)
| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/api/user` | — | Get authenticated user |
| GET | `/api/posts` | `api.posts.index` | List user's posts (filterable by status) |
| POST | `/api/posts` | `api.posts.store` | Create a post |
| GET | `/api/posts/{post}` | `api.posts.show` | Show a post (policy-checked) |
| PUT | `/api/posts/{post}` | `api.posts.update` | Update a post (policy-checked) |
| DELETE | `/api/posts/{post}` | `api.posts.destroy` | Delete a post (policy-checked) |

All routes are protected by `auth:sanctum` middleware.

### API Controller
- **PostController** (`app/Http/Controllers/Api/PostController.php`)
  - Uses `JsonResource` for consistent response format
  - Policy authorization on show/update/delete
  - Pagination (15 per page)
  - Status filter query parameter

### Token Management UI
- **ApiTokens** (`app/Livewire/Settings/ApiTokens.php`)
  - Create new tokens with a name
  - Displays plain text token once after creation (never shown again)
  - Lists all tokens with creation date
  - Revoke (delete) individual tokens with confirmation
- Added "API Tokens" tab in Settings page

### Base Controller
- Added `AuthorizesRequests` trait to base Controller class

## Tests Added (13 new tests)

- `tests/Feature/Api/PostApiTest.php` — 8 tests (auth, list, create, show, update, delete, policy, user endpoint)
- `tests/Feature/Settings/ApiTokensTest.php` — 5 tests (render, create, display token, validation, revoke)

**Total: 130 tests passing (279 assertions)**
