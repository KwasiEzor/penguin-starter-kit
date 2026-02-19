<?php

use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;

it('allows admin to access payment settings page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.payments'))
        ->assertOk()
        ->assertSee('Payments');
});

it('forbids non-admin from accessing payment settings', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.payments'))
        ->assertForbidden();
});

it('redirects guests to login', function (): void {
    $this->get(route('admin.payments'))
        ->assertRedirect(route('login'));
});

it('can save payment settings', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('paymentsEnabled', true)
        ->set('stripeKey', 'pk_test_123')
        ->set('stripeSecret', 'sk_test_123')
        ->set('stripeWebhookSecret', 'whsec_test_123')
        ->set('currency', 'usd')
        ->call('saveSettings')
        ->assertHasNoErrors();

    expect(Setting::get('payments.enabled'))->toBe('1');
    expect(Setting::get('payments.stripe_key'))->toBe('pk_test_123');
    expect(Setting::get('payments.currency'))->toBe('usd');
});

it('validates stripe key prefix', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('stripeKey', 'invalid_key')
        ->call('saveSettings')
        ->assertHasErrors('stripeKey');
});

it('validates stripe secret prefix', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('stripeSecret', 'invalid_secret')
        ->call('saveSettings')
        ->assertHasErrors('stripeSecret');
});

it('validates webhook secret prefix', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('stripeWebhookSecret', 'invalid_webhook')
        ->call('saveSettings')
        ->assertHasErrors('stripeWebhookSecret');
});

it('encrypts stripe secret when saving', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('stripeSecret', 'sk_test_encrypted')
        ->call('saveSettings')
        ->assertHasNoErrors();

    $stored = Setting::get('payments.stripe_secret');
    expect($stored)->not->toBe('sk_test_encrypted');
    expect(\Illuminate\Support\Facades\Crypt::decryptString($stored))->toBe('sk_test_encrypted');
});

it('can toggle payments on and off', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('paymentsEnabled', true)
        ->call('saveSettings')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.payments.enabled');
    expect(Setting::paymentsEnabled())->toBeTrue();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\Settings::class)
        ->set('paymentsEnabled', false)
        ->call('saveSettings')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.payments.enabled');
    expect(Setting::paymentsEnabled())->toBeFalse();
});
