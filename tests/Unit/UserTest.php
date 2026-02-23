<?php

/**
 * Tests for the User model's initials generation.
 *
 * Verifies that initials are correctly derived from full names, single names,
 * multi-word names (using the first two words), and that initials are always
 * returned in uppercase.
 */

use App\Models\User;

it('generates initials from full name', function (): void {
    $user = new User(['name' => 'John Doe']);
    expect($user->initials())->toBe('JD');
});

it('generates initials from single name', function (): void {
    $user = new User(['name' => 'John']);
    expect($user->initials())->toBe('J');
});

it('generates initials from three word name taking first two', function (): void {
    $user = new User(['name' => 'John Michael Doe']);
    expect($user->initials())->toBe('JM');
});

it('generates uppercase initials', function (): void {
    $user = new User(['name' => 'jane doe']);
    expect($user->initials())->toBe('JD');
});
