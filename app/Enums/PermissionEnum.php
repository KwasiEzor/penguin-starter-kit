<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionEnum: string
{
    case UsersView = 'users.view';
    case UsersCreate = 'users.create';
    case UsersEdit = 'users.edit';
    case UsersDelete = 'users.delete';
    case PostsView = 'posts.view';
    case PostsCreate = 'posts.create';
    case PostsEdit = 'posts.edit';
    case PostsDelete = 'posts.delete';
    case PostsPublish = 'posts.publish';
    case AdminAccess = 'admin.access';
    case RolesView = 'roles.view';
    case RolesEdit = 'roles.edit';
    case PaymentsManage = 'payments.manage';

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
        };
    }

    public function group(): string
    {
        return match ($this) {
            self::UsersView, self::UsersCreate, self::UsersEdit, self::UsersDelete => 'Users',
            self::PostsView, self::PostsCreate, self::PostsEdit, self::PostsDelete, self::PostsPublish => 'Posts',
            self::AdminAccess => 'Admin',
            self::RolesView, self::RolesEdit => 'Roles',
            self::PaymentsManage => 'Payments',
        };
    }
}
