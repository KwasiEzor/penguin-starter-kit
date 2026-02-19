<?php

use App\Livewire\Admin\Roles;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

it('renders the roles index for admin', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.roles.index'))
        ->assertOk()
        ->assertSee('Roles');
});

it('forbids non-admin from accessing roles index', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.roles.index'))
        ->assertForbidden();
});

it('shows all roles with user and permission counts', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.roles.index'))
        ->assertSee('Admin')
        ->assertSee('Editor')
        ->assertSee('User');
});

it('renders the create role page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.roles.create'))
        ->assertOk()
        ->assertSee('Create Role');
});

it('can create a role with permissions', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Roles\Create::class)
        ->set('name', 'moderator')
        ->set('selectedPermissions', ['posts.view', 'posts.edit'])
        ->call('save');

    $role = Role::where('name', 'moderator')->first();
    expect($role)->not->toBeNull();
    expect($role->permissions->pluck('name')->toArray())->toContain('posts.view', 'posts.edit');
});

it('renders the edit role page', function (): void {
    $admin = User::factory()->admin()->create();
    $role = Role::where('name', 'editor')->first();

    $this->actingAs($admin)
        ->get(route('admin.roles.edit', $role))
        ->assertOk()
        ->assertSee('Edit Role');
});

it('can update a role', function (): void {
    $admin = User::factory()->admin()->create();
    $role = Role::create(['name' => 'custom-role', 'guard_name' => 'web']);

    Livewire::actingAs($admin)
        ->test(Roles\Edit::class, ['role' => $role])
        ->set('name', 'renamed-role')
        ->set('selectedPermissions', ['admin.access', 'users.view'])
        ->call('save');

    $role->refresh();
    expect($role->name)->toBe('renamed-role');
    expect($role->permissions->pluck('name')->toArray())->toContain('admin.access', 'users.view');
});

it('cannot delete the admin role', function (): void {
    $admin = User::factory()->admin()->create();
    $adminRole = Role::where('name', 'admin')->first();

    Livewire::actingAs($admin)
        ->test(Roles\Index::class)
        ->call('confirmDelete', $adminRole->id)
        ->call('deleteRole');

    expect(Role::where('name', 'admin')->exists())->toBeTrue();
});

it('cannot delete a role with users', function (): void {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $userRole = Role::where('name', 'user')->first();

    Livewire::actingAs($admin)
        ->test(Roles\Index::class)
        ->call('confirmDelete', $userRole->id)
        ->call('deleteRole');

    expect(Role::where('name', 'user')->exists())->toBeTrue();
});

it('can delete a role with no users', function (): void {
    $admin = User::factory()->admin()->create();
    $emptyRole = Role::create(['name' => 'empty-role', 'guard_name' => 'web']);

    Livewire::actingAs($admin)
        ->test(Roles\Index::class)
        ->call('confirmDelete', $emptyRole->id)
        ->call('deleteRole');

    expect(Role::where('name', 'empty-role')->exists())->toBeFalse();
});
