<?php

use App\Models\User;

it('identifies admin users', function () {
    $admin = new User(['role' => 'admin']);

    expect($admin->isAdmin())->toBeTrue();
});

it('identifies regular users', function () {
    $user = new User(['role' => 'user']);

    expect($user->isAdmin())->toBeFalse();
});
