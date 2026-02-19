<?php

use App\Enums\RoleEnum;
use App\Models\User;

it('identifies admin users', function (): void {
    $admin = User::factory()->admin()->create();

    expect($admin->isAdmin())->toBeTrue();
});

it('identifies regular users', function (): void {
    $user = User::factory()->create();

    expect($user->isAdmin())->toBeFalse();
});

it('identifies editor users', function (): void {
    $editor = User::factory()->editor()->create();

    expect($editor->isAdmin())->toBeFalse();
    expect($editor->hasRole(RoleEnum::Editor))->toBeTrue();
});
