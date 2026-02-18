<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

it('can set and get a value', function () {
    Setting::set('test.key', 'test-value');

    expect(Setting::get('test.key'))->toBe('test-value');
});

it('returns default when key does not exist', function () {
    expect(Setting::get('nonexistent.key', 'default'))->toBe('default');
});

it('returns null when key does not exist and no default', function () {
    expect(Setting::get('nonexistent.key'))->toBeNull();
});

it('caches values', function () {
    Setting::set('cached.key', 'cached-value');

    // Value should be cached
    expect(Cache::has('setting.cached.key'))->toBeFalse(); // cleared on set

    // First get caches it
    Setting::get('cached.key');
    expect(Cache::has('setting.cached.key'))->toBeTrue();
});

it('clears cache when setting a value', function () {
    Setting::set('clear.key', 'value1');
    Setting::get('clear.key'); // populate cache

    Setting::set('clear.key', 'value2');
    expect(Setting::get('clear.key'))->toBe('value2');
});

it('reports payments as disabled by default', function () {
    expect(Setting::paymentsEnabled())->toBeFalse();
});

it('reports payments as enabled when setting is true', function () {
    Setting::set('payments.enabled', '1', 'payments');

    // Clear the cache from previous get calls
    Cache::forget('setting.payments.enabled');

    expect(Setting::paymentsEnabled())->toBeTrue();
});

it('stores settings with group', function () {
    Setting::set('grouped.key', 'value', 'custom-group');

    $setting = Setting::where('key', 'grouped.key')->first();
    expect($setting->group)->toBe('custom-group');
});

it('updates existing setting instead of creating duplicate', function () {
    Setting::set('unique.key', 'value1');
    Setting::set('unique.key', 'value2');

    expect(Setting::where('key', 'unique.key')->count())->toBe(1);
    expect(Setting::where('key', 'unique.key')->first()->value)->toBe('value2');
});
