<?php

/**
 * Tests for the admin AI settings management feature.
 *
 * Covers access control for the AI settings page, saving and encrypting
 * global API keys for AI providers (OpenAI, Anthropic), and toggling
 * the AI enabled/disabled setting.
 */

use App\Models\AiApiKey;
use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;

it('allows admin to access AI settings page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.ai-settings'))
        ->assertOk()
        ->assertSee('AI Settings');
});

it('forbids non-admin from accessing AI settings', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.ai-settings'))
        ->assertForbidden();
});

it('can save global API keys', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\AiSettings::class)
        ->set('openaiKey', 'sk-test-key-123')
        ->call('saveSettings')
        ->assertHasNoErrors();

    $key = AiApiKey::where('provider', 'openai')->whereNull('user_id')->first();
    expect($key)->not->toBeNull();
    expect($key->getDecryptedKey())->toBe('sk-test-key-123');
});

it('stores API keys encrypted', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\AiSettings::class)
        ->set('anthropicKey', 'sk-ant-test')
        ->call('saveSettings')
        ->assertHasNoErrors();

    $key = AiApiKey::where('provider', 'anthropic')->whereNull('user_id')->first();
    expect($key->getDecryptedKey())->toBe('sk-ant-test');
    // The raw DB value should not be the plain text
    expect($key->getRawOriginal('api_key'))->not->toBe('sk-ant-test');
});

it('can toggle AI enabled on and off', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\AiSettings::class)
        ->set('aiEnabled', true)
        ->call('saveSettings')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.ai.enabled');
    expect(Setting::get('ai.enabled'))->toBe('1');

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\AiSettings::class)
        ->set('aiEnabled', false)
        ->call('saveSettings')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.ai.enabled');
    expect(Setting::get('ai.enabled'))->toBe('0');
});
