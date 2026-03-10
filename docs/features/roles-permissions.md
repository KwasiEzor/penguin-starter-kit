# Roles & Permissions

Role-based access control powered by [Spatie Laravel Permission](https://github.com/spatie/laravel-permission).

## Built-in Roles

| Role | Permissions |
|---|---|
| **Administrator** | All 15 permissions |
| **Editor** | Admin access, all post permissions, view users |
| **User** | View posts, create posts |

## 15 Granular Permissions

| Group | Permissions |
|---|---|
| **Users** | `users.view`, `users.create`, `users.edit`, `users.delete` |
| **Posts** | `posts.view`, `posts.create`, `posts.edit`, `posts.delete`, `posts.publish` |
| **Admin** | `admin.access`, `settings.manage` |
| **Roles** | `roles.view`, `roles.edit` |
| **Payments** | `payments.manage` |
| **AI** | `ai-agents.manage` |

## Custom Roles

Custom roles can be created from **Admin > Roles** with any combination of the 15 permissions.

### Safeguards

- Cannot delete the admin role
- Cannot demote the last admin
- Cannot delete roles with assigned users

## Implementation

Roles and permissions are managed through Spatie's permission package with enums:

```php
// Check permissions
$user->hasPermissionTo(PermissionEnum::POSTS_CREATE);

// Check roles
$user->hasRole(RoleEnum::ADMIN);

// In Blade templates
@can('posts.create')
    <x-button>Create Post</x-button>
@endcan
```

## Middleware

Admin routes are protected by the `EnsureUserIsAdmin` middleware, which checks for the `admin.access` permission.
