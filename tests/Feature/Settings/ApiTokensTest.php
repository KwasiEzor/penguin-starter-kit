<?php

use App\Models\User;
use Livewire\Livewire;

it('renders the api tokens settings component', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\ApiTokens::class)
        ->assertSee('API Tokens');
});

it('creates a new api token', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\ApiTokens::class)
        ->set('tokenName', 'Test Token')
        ->call('createToken')
        ->assertSet('tokenName', '');

    expect($user->tokens()->count())->toBe(1);
    expect($user->tokens()->first()->name)->toBe('Test Token');
});

it('shows the new token after creation', function (): void {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\ApiTokens::class)
        ->set('tokenName', 'My Token')
        ->call('createToken');

    expect($component->get('newToken'))->not->toBeNull();
});

it('validates token name is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\ApiTokens::class)
        ->set('tokenName', '')
        ->call('createToken')
        ->assertHasErrors(['tokenName']);
});

it('can revoke a token', function (): void {
    $user = User::factory()->create();
    $token = $user->createToken('Old Token');

    Livewire::actingAs($user)
        ->test(\App\Livewire\Settings\ApiTokens::class)
        ->call('confirmDelete', $token->accessToken->id)
        ->call('deleteToken');

    expect($user->tokens()->count())->toBe(0);
});
