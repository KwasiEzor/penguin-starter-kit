<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        foreach (PermissionEnum::cases() as $permission) {
            Permission::findOrCreate($permission->value, 'web');
        }

        // Create roles and assign permissions
        foreach (RoleEnum::cases() as $roleEnum) {
            $role = Role::findOrCreate($roleEnum->value, 'web');

            $permissions = match ($roleEnum) {
                RoleEnum::Admin => collect(PermissionEnum::cases())->pluck('value')->all(),
                RoleEnum::Editor => [
                    PermissionEnum::AdminAccess->value,
                    PermissionEnum::PostsView->value,
                    PermissionEnum::PostsCreate->value,
                    PermissionEnum::PostsEdit->value,
                    PermissionEnum::PostsDelete->value,
                    PermissionEnum::PostsPublish->value,
                    PermissionEnum::UsersView->value,
                ],
                RoleEnum::User => [
                    PermissionEnum::PostsView->value,
                    PermissionEnum::PostsCreate->value,
                ],
            };

            $role->syncPermissions($permissions);
        }
    }
}
