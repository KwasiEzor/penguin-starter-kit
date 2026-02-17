<?php

use App\Enums\RoleEnum;
use App\Models\User;

it('identifies admin users', function () {
    $admin = User::factory()->admin()->create();

    expect($admin->isAdmin())->toBeTrue();
});

it('identifies regular users', function () {
    $user = User::factory()->create();

    expect($user->isAdmin())->toBeFalse();
});

it('identifies editor users', function () {
    $editor = User::factory()->editor()->create();

    expect($editor->isAdmin())->toBeFalse();
    expect($editor->hasRole(RoleEnum::Editor))->toBeTrue();
});
