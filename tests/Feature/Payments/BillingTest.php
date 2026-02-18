<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::flush();
});

it('returns 404 when payments are disabled', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertNotFound();
});

it('requires authentication', function () {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $this->get(route('billing'))
        ->assertRedirect(route('login'));
});

it('shows billing page when payments are enabled', function () {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertOk()
        ->assertSee('Billing');
});

it('shows subscription info when user has no subscription', function () {
    Setting::set('payments.enabled', '1', 'payments');
    Cache::forget('setting.payments.enabled');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('billing'))
        ->assertSee('View Plans');
});
