<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Application permission definitions.
 *
 * Defines all granular permissions used for role-based access control throughout
 * the application. Permissions are organized into logical groups (Users, Posts,
 * Admin, Roles, Payments, AI).
 *
 * @case UsersView     - Permission to view user listings and profiles
 * @case UsersCreate   - Permission to create new user accounts
 * @case UsersEdit     - Permission to modify existing user accounts
 * @case UsersDelete   - Permission to delete user accounts
 * @case PostsView     - Permission to view posts
 * @case PostsCreate   - Permission to create new posts
 * @case PostsEdit     - Permission to edit existing posts
 * @case PostsDelete   - Permission to delete posts
 * @case PostsPublish  - Permission to publish draft posts
 * @case AdminAccess   - Permission to access the admin panel
 * @case RolesView     - Permission to view roles and their permissions
 * @case RolesEdit     - Permission to modify roles and assign permissions
 * @case PaymentsManage - Permission to manage payment settings and products
 * @case AiAgentsManage - Permission to manage AI agents and their configurations
 */
enum PermissionEnum: string
{
    /** Permission to view user listings and profiles. */
    case UsersView = 'users.view';

    /** Permission to create new user accounts. */
    case UsersCreate = 'users.create';

    /** Permission to modify existing user accounts. */
    case UsersEdit = 'users.edit';

    /** Permission to delete user accounts. */
    case UsersDelete = 'users.delete';

    /** Permission to view posts. */
    case PostsView = 'posts.view';

    /** Permission to create new posts. */
    case PostsCreate = 'posts.create';

    /** Permission to edit existing posts. */
    case PostsEdit = 'posts.edit';

    /** Permission to delete posts. */
    case PostsDelete = 'posts.delete';

    /** Permission to publish draft posts. */
    case PostsPublish = 'posts.publish';

    /** Permission to access the admin panel. */
    case AdminAccess = 'admin.access';

    /** Permission to view roles and their permissions. */
    case RolesView = 'roles.view';

    /** Permission to modify roles and assign permissions. */
    case RolesEdit = 'roles.edit';

    /** Permission to manage payment settings and products. */
    case PaymentsManage = 'payments.manage';

    /** Permission to manage AI agents and their configurations. */
    case AiAgentsManage = 'ai-agents.manage';

    /**
     * Get the human-readable display label for this permission.
     *
     * @return string The formatted permission name
     */
    public function label(): string
    {
        return match ($this) {
            self::UsersView => 'View Users',
            self::UsersCreate => 'Create Users',
            self::UsersEdit => 'Edit Users',
            self::UsersDelete => 'Delete Users',
            self::PostsView => 'View Posts',
            self::PostsCreate => 'Create Posts',
            self::PostsEdit => 'Edit Posts',
            self::PostsDelete => 'Delete Posts',
            self::PostsPublish => 'Publish Posts',
            self::AdminAccess => 'Admin Access',
            self::RolesView => 'View Roles',
            self::RolesEdit => 'Edit Roles',
            self::PaymentsManage => 'Manage Payments',
            self::AiAgentsManage => 'Manage AI Agents',
        };
    }

    /**
     * Get the logical group this permission belongs to.
     *
     * Used for organizing permissions in the UI when displaying or assigning
     * permissions to roles.
     *
     * @return string The group name (e.g., 'Users', 'Posts', 'Admin', 'Roles', 'Payments', 'AI')
     */
    public function group(): string
    {
        return match ($this) {
            self::UsersView, self::UsersCreate, self::UsersEdit, self::UsersDelete => 'Users',
            self::PostsView, self::PostsCreate, self::PostsEdit, self::PostsDelete, self::PostsPublish => 'Posts',
            self::AdminAccess => 'Admin',
            self::RolesView, self::RolesEdit => 'Roles',
            self::PaymentsManage => 'Payments',
            self::AiAgentsManage => 'AI',
        };
    }
}
