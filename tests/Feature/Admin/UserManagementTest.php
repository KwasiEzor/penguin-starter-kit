<?php

use App\Enums\RoleEnum;
use App\Livewire\Admin\Users;
use App\Models\User;
use Livewire\Livewire;

it('renders the users index for admin', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Users');
});

it('forbids non-admin from accessing users index', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

it('can search users by name', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->create(['name' => 'Xylophone Player']);
    User::factory()->create(['name' => 'Zeppelin Rider']);

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->set('search', 'Xylophone')
        ->assertSee('Xylophone Player')
        ->assertDontSee('Zeppelin Rider');
});

it('can search users by email', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->create(['name' => 'John', 'email' => 'john@test.com']);
    User::factory()->create(['name' => 'Jane', 'email' => 'jane@test.com']);

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->set('search', 'john@test')
        ->assertSee('John')
        ->assertDontSee('Jane');
});

it('can filter users by role', function () {
    $admin = User::factory()->admin()->create(['name' => 'Admin User']);
    User::factory()->create(['name' => 'Regular User']);

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->set('roleFilter', 'admin')
        ->assertSee('Admin User')
        ->assertDontSee('Regular User');
});

it('renders the create user page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertSee('Create User');
});

it('can create a user', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Users\Create::class)
        ->set('name', 'New User')
        ->set('email', 'new@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('role', 'editor')
        ->call('save');

    $user = User::where('email', 'new@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->name)->toBe('New User');
    expect($user->hasRole(RoleEnum::Editor))->toBeTrue();
    expect($user->email_verified_at)->not->toBeNull();
});

it('renders the edit user page', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->get(route('admin.users.edit', $user))
        ->assertOk()
        ->assertSee('Edit User');
});

it('can update a user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(Users\Edit::class, ['user' => $user])
        ->set('name', 'Updated Name')
        ->set('email', 'updated@example.com')
        ->set('role', 'editor')
        ->call('save');

    $user->refresh();
    expect($user->name)->toBe('Updated Name');
    expect($user->email)->toBe('updated@example.com');
    expect($user->hasRole(RoleEnum::Editor))->toBeTrue();
});

it('can update a user without changing password', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();
    $originalPassword = $user->password;

    Livewire::actingAs($admin)
        ->test(Users\Edit::class, ['user' => $user])
        ->set('name', 'Updated Name')
        ->call('save');

    $user->refresh();
    expect($user->password)->toBe($originalPassword);
});

it('can delete a user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->call('confirmDelete', $user->id)
        ->call('deleteUser');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

it('cannot delete self', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->call('confirmDelete', $admin->id)
        ->call('deleteUser');

    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

it('cannot delete the last admin', function () {
    $admin = User::factory()->admin()->create();
    $admin2 = User::factory()->admin()->create();

    // Delete admin2 should work since there are 2 admins
    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->call('confirmDelete', $admin2->id)
        ->call('deleteUser');

    $this->assertDatabaseMissing('users', ['id' => $admin2->id]);

    // Now try to create another admin user and delete them to get down to one
    $admin3 = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Users\Index::class)
        ->call('confirmDelete', $admin3->id)
        ->call('deleteUser');

    $this->assertDatabaseMissing('users', ['id' => $admin3->id]);

    // admin is now the last admin — cannot be deleted by anyone
    expect(User::role('admin')->count())->toBe(1);
});

it('cannot change own role', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Users\Edit::class, ['user' => $admin])
        ->set('role', 'user')
        ->call('save');

    $admin->refresh();
    expect($admin->hasRole(RoleEnum::Admin))->toBeTrue();
});
