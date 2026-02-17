# Milestone 3: Roles, Permissions, and Admin Area

## Summary

Added a simple role-based authorization system with admin middleware, PostPolicy for resource-level authorization, and an admin dashboard with application statistics.

## What Was Added

### Role System
- **Migration** — adds `role` column (default: `user`) to users table
- **User::isAdmin()** — checks if user has `admin` role
- **UserFactory::admin()** — factory state for creating admin users
- **Seeder** — test user is now an admin by default

### Admin Middleware
- **EnsureUserIsAdmin** (`app/Http/Middleware/EnsureUserIsAdmin.php`) — returns 403 for non-admin users
- Registered as `admin` alias in `bootstrap/app.php`

### PostPolicy
- `viewAny` — all authenticated users
- `view` — owner or admin
- `create` — all authenticated users
- `update` — owner or admin
- `delete` — owner or admin

### Admin Dashboard
- **Route**: `GET /admin/dashboard` (middleware: `auth`, `admin`)
- **Stats cards**: Total Users, Total Posts, Published Posts
- **Recent Users**: last 5 users with role badge
- **Recent Posts**: last 5 posts with author and status

### Navigation
- Admin section in sidebar (only visible to admins) with shield icon
- Active state on `admin.*` routes

### Policy Integration
- `Posts\Edit` now uses `$this->authorize('update', $post)` instead of manual check
- `Posts\Index::deletePost()` now uses `$this->authorize('delete', $post)`

## Tests Added (12 new tests)

- `tests/Feature/Admin/AdminDashboardTest.php` — 4 tests (admin access, non-admin blocked, guest redirect, stats display)
- `tests/Feature/Admin/PostPolicyTest.php` — 6 tests (owner update/delete, non-owner blocked, admin can update/delete any)
- `tests/Unit/UserRoleTest.php` — 2 tests (admin identification)

**Total: 110 tests passing (248 assertions)**
