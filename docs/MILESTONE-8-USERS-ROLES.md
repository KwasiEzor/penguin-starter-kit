# Milestone 8: Users & Roles Management with Spatie Permission

## Overview

Replaced the simple `role` string column on the users table with [spatie/laravel-permission](https://github.com/spatie/laravel-permission) for battle-tested role and permission management. Added full CRUD for both users and roles in the admin panel.

## What Changed

### Spatie Permission Integration
- Installed `spatie/laravel-permission` v7
- Created `RoleEnum` and `PermissionEnum` PHP enums for type-safe role/permission references
- Data migration converts existing `role` string column to Spatie roles
- `HasRoles` trait added to User model
- All role checks now use Spatie methods (`hasRole()`, `hasPermissionTo()`)

### Roles & Permissions
Three default roles with granular permissions:
- **Admin**: All permissions (12 total)
- **Editor**: Admin access, all post permissions, view users (7 permissions)
- **User**: View and create posts (2 permissions)

Permission groups: Users, Posts, Admin, Roles

### User Management (`/admin/users`)
- **Index**: Paginated table with avatar, name, email, role badge, search, role filter, delete with confirmation
- **Create**: Name, email, password, role select, avatar upload; auto-verifies email
- **Edit**: Update name, email, optional password change, role change, avatar upload/remove
- Safety: Cannot delete self, cannot delete last admin, cannot change own role

### Role Management (`/admin/roles`)
- **Index**: Table with name, user count, permission count, edit/delete actions
- **Create**: Role name, permission checkboxes grouped by category
- **Edit**: Same as create; admin role name is read-only
- Safety: Cannot delete admin role, cannot delete roles with assigned users

### Updated Components
- **Sidebar**: Admin section now shows Dashboard, Users, and Roles links (uses `@can('admin.access')`)
- **Admin Dashboard**: Displays role badge from Spatie roles
- **Middleware**: `EnsureUserIsAdmin` checks `admin.access` permission
- **PostPolicy**: Uses granular `posts.edit` and `posts.delete` permissions
- **UserFactory**: Default `configure()` assigns User role; `admin()` and `editor()` states

## New Files

| File | Purpose |
|------|---------|
| `app/Enums/RoleEnum.php` | Role enum with values & labels |
| `app/Enums/PermissionEnum.php` | Permission enum with values, labels & groups |
| `database/migrations/..._migrate_users_role_to_spatie.php` | Data migration from string to Spatie |
| `database/seeders/RolesAndPermissionsSeeder.php` | Seeds roles & permissions |
| `app/Livewire/Admin/Users/Index.php` | User listing component |
| `app/Livewire/Admin/Users/Create.php` | User creation component |
| `app/Livewire/Admin/Users/Edit.php` | User editing component |
| `app/Livewire/Admin/Roles/Index.php` | Role listing component |
| `app/Livewire/Admin/Roles/Create.php` | Role creation component |
| `app/Livewire/Admin/Roles/Edit.php` | Role editing component |
| `resources/views/livewire/admin/users/*.blade.php` | User management views |
| `resources/views/livewire/admin/roles/*.blade.php` | Role management views |
| `tests/Feature/Admin/UserManagementTest.php` | 14 user CRUD tests |
| `tests/Feature/Admin/RoleManagementTest.php` | 10 role CRUD tests |
| `tests/Feature/Admin/UserRoleTest.php` | 3 role identification tests |

## Modified Files

| File | Change |
|------|--------|
| `app/Models/User.php` | Added `HasRoles` trait, removed `role` from fillable, updated `isAdmin()` |
| `app/Http/Middleware/EnsureUserIsAdmin.php` | Permission-based check |
| `app/Policies/PostPolicy.php` | Permission-based authorization |
| `database/factories/UserFactory.php` | Role-based factory states with `configure()` |
| `database/seeders/DatabaseSeeder.php` | Calls `RolesAndPermissionsSeeder` first |
| `routes/web.php` | Admin user/role routes |
| `resources/views/components/sidebar.blade.php` | Admin nav with Dashboard, Users, Roles links |
| `resources/views/livewire/admin/dashboard.blade.php` | Role name from Spatie |
| `app/Livewire/Admin/Dashboard.php` | Eager-loads roles |
| `tests/Pest.php` | Seeds roles/permissions in Feature test `beforeEach` |

## Testing

```bash
php artisan test
# 173 passed (363 assertions)
```

27 new tests covering user CRUD, role CRUD, safety guards, and role identification.
