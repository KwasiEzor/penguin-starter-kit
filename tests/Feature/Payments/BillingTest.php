<?php

/**
 * Tests for the billing page functionality.
 *
 * Verifies that the billing page respects the payments enabled/disabled setting,
 * requires authentication, displays correctly when enabled, and shows appropriate
 * subscription information for users without an active subscription.
 */

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

beforeEach(function (): void {
    Cache::flush();
});

it('returns 404 when payments are disabled', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertNotFound();
});

it('requires authentication', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $this->get(route('billing'))
        ->assertRedirect(route('login'));
});

it('shows billing page when payments are enabled', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertOk()
        ->assertSee('Billing');
});

it('shows subscription info when user has no subscription', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertSee('View Plans');
});
