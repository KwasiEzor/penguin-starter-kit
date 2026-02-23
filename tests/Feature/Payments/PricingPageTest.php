<?php

/**
 * Tests for the pricing page functionality.
 *
 * Verifies that the pricing page respects the payments enabled/disabled setting,
 * displays correctly when enabled, and only shows active plans and products
 * while hiding inactive ones.
 */

use App\Models\Plan;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

beforeEach(function (): void {
    Cache::flush();
});

it('returns 404 when payments are disabled', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('pricing'))
        ->assertNotFound();
});

it('shows pricing page when payments are enabled', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('pricing'))
        ->assertOk()
        ->assertSee('Pricing');
});

it('only shows active plans', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $activePlan = Plan::factory()->create(['name' => 'Active Plan', 'is_active' => true]);
    $inactivePlan = Plan::factory()->create(['name' => 'Inactive Plan', 'is_active' => false]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('pricing'))
        ->assertSee('Active Plan')
        ->assertDontSee('Inactive Plan');
});

it('only shows active products', function (): void {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $activeProduct = Product::factory()->create(['name' => 'Active Product', 'is_active' => true]);
    $inactiveProduct = Product::factory()->create(['name' => 'Inactive Product', 'is_active' => false]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('pricing'))
        ->assertSee('Active Product')
        ->assertDontSee('Inactive Product');
});
