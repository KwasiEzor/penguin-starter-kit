<?php

use App\Enums\AiProviderEnum;
use App\Models\AiAgent;
use App\Models\AiApiKey;
use App\Models\AiExecution;
use App\Models\User;
use App\Services\Ai\AiService;

it('creates an execution record when executing a task', function (): void {
    $user = User::factory()->create();
    $agent = AiAgent::factory()->for($user)->forProvider(AiProviderEnum::OpenAi)->create();

    AiApiKey::create([
        'user_id' => null,
        'provider' => 'openai',
        'api_key' => 'sk-test-key',
        'is_active' => true,
    ]);

    $service = Mockery::mock(AiService::class);
    $service->shouldReceive('execute')
        ->once()
        ->andReturn(AiExecution::create([
            'ai_agent_id' => $agent->id,
            'user_id' => $user->id,
            'input' => 'Test input',
            'output' => 'Test output',
            'status' => 'completed',
            'tokens_input' => 10,
            'tokens_output' => 20,
            'execution_time_ms' => 150,
        ]));

    app()->instance(AiService::class, $service);

    Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Show::class, ['aiAgent' => $agent])
        ->set('taskInput', 'Test input')
        ->call('executeTask');

    $this->assertDatabaseHas('ai_executions', [
        'ai_agent_id' => $agent->id,
        'user_id' => $user->id,
        'input' => 'Test input',
    ]);
});

it('can execute on a public agent', function (): void {
    $owner = User::factory()->create();
    $user = User::factory()->create();
    $agent = AiAgent::factory()->for($owner)->public()->forProvider(AiProviderEnum::OpenAi)->create();

    AiApiKey::create([
        'user_id' => null,
        'provider' => 'openai',
        'api_key' => 'sk-test-key',
        'is_active' => true,
    ]);

    $service = Mockery::mock(AiService::class);
    $service->shouldReceive('execute')
        ->once()
        ->andReturn(AiExecution::create([
            'ai_agent_id' => $agent->id,
            'user_id' => $user->id,
            'input' => 'Hello',
            'output' => 'Hi there',
            'status' => 'completed',
        ]));

    app()->instance(AiService::class, $service);

    Livewire\Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Show::class, ['aiAgent' => $agent])
        ->set('taskInput', 'Hello')
        ->call('executeTask')
        ->assertHasNoErrors();
});

it('cannot execute on a private agent of another user', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $agent = AiAgent::factory()->for($owner)->create(['is_public' => false]);

    Livewire\Livewire::actingAs($other)
        ->test(\App\Livewire\AiAgents\Show::class, ['aiAgent' => $agent])
        ->assertForbidden();
});

it('resolves user key over global key', function (): void {
    $user = User::factory()->create();

    AiApiKey::create([
        'user_id' => null,
        'provider' => 'openai',
        'api_key' => 'global-key',
        'is_active' => true,
    ]);

    AiApiKey::create([
        'user_id' => $user->id,
        'provider' => 'openai',
        'api_key' => 'user-key',
        'is_active' => true,
    ]);

    $service = new AiService;
    $key = $service->resolveApiKey(AiProviderEnum::OpenAi, $user);

    expect($key)->toBe('user-key');
});

it('falls back to global key when user has no key', function (): void {
    $user = User::factory()->create();

    AiApiKey::create([
        'user_id' => null,
        'provider' => 'openai',
        'api_key' => 'global-key',
        'is_active' => true,
    ]);

    $service = new AiService;
    $key = $service->resolveApiKey(AiProviderEnum::OpenAi, $user);

    expect($key)->toBe('global-key');
});

it('throws exception when no key is configured', function (): void {
    $user = User::factory()->create();

    $service = new AiService;
    $service->resolveApiKey(AiProviderEnum::OpenAi, $user);
})->throws(RuntimeException::class);

it('tracks token usage in execution', function (): void {
    $user = User::factory()->create();
    $agent = AiAgent::factory()->for($user)->create();

    $execution = AiExecution::create([
        'ai_agent_id' => $agent->id,
        'user_id' => $user->id,
        'input' => 'Test',
        'output' => 'Response',
        'status' => 'completed',
        'tokens_input' => 50,
        'tokens_output' => 100,
        'execution_time_ms' => 250,
    ]);

    expect($execution->tokens_input)->toBe(50);
    expect($execution->tokens_output)->toBe(100);
    expect($execution->execution_time_ms)->toBe(250);
});
