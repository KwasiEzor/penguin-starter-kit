<?php

use App\Models\AiApiKey;
use App\Models\User;
use Livewire\Livewire;

it('user can save personal API keys', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\AiApiKeys::class)
        ->set('openaiKey', 'sk-user-key-123')
        ->call('saveKeys')
        ->assertHasNoErrors();

    $key = AiApiKey::where('provider', 'openai')->where('user_id', $user->id)->first();
    expect($key)->not->toBeNull();
    expect($key->getDecryptedKey())->toBe('sk-user-key-123');
});

it('stores user keys encrypted', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\AiApiKeys::class)
        ->set('anthropicKey', 'sk-ant-user')
        ->call('saveKeys')
        ->assertHasNoErrors();

    $key = AiApiKey::where('provider', 'anthropic')->where('user_id', $user->id)->first();
    expect($key->getDecryptedKey())->toBe('sk-ant-user');
    expect($key->getRawOriginal('api_key'))->not->toBe('sk-ant-user');
});

it('can remove a personal API key', function (): void {
    $user = User::factory()->create();

    AiApiKey::create([
        'user_id' => $user->id,
        'provider' => 'openai',
        'api_key' => 'test-key',
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\AiApiKeys::class)
        ->call('removeKey', 'openai');

    $this->assertDatabaseMissing('ai_api_keys', [
        'user_id' => $user->id,
        'provider' => 'openai',
    ]);
});

it('does not save empty keys', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\AiApiKeys::class)
        ->set('openaiKey', '')
        ->set('anthropicKey', '')
        ->set('geminiKey', '')
        ->call('saveKeys')
        ->assertHasNoErrors();

    expect(AiApiKey::where('user_id', $user->id)->count())->toBe(0);
});
