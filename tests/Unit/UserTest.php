<?php

use App\Models\User;

it('generates initials from full name', function () {
    $user = new User(['name' => 'John Doe']);
    expect($user->initials())->toBe('JD');
});

it('generates initials from single name', function () {
    $user = new User(['name' => 'John']);
    expect($user->initials())->toBe('J');
});

it('generates initials from three word name taking first two', function () {
    $user = new User(['name' => 'John Michael Doe']);
    expect($user->initials())->toBe('JM');
});

it('generates uppercase initials', function () {
    $user = new User(['name' => 'jane doe']);
    expect($user->initials())->toBe('JD');
});
