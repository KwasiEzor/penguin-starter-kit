<?php

use App\Models\AiAgent;
use App\Models\User;
use Livewire\Livewire;

it('renders the agents index page for authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('agents.index'))
        ->assertOk();
});

it('can create an agent', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Create::class)
        ->set('name', 'Test Agent')
        ->set('description', 'A test agent')
        ->set('provider', 'openai')
        ->set('model', 'gpt-4o')
        ->set('system_prompt', 'You are a test assistant.')
        ->set('temperature', '0.5')
        ->set('max_tokens', '512')
        ->call('save')
        ->assertRedirect(route('agents.index'));

    $this->assertDatabaseHas('ai_agents', [
        'name' => 'Test Agent',
        'user_id' => $user->id,
        'provider' => 'openai',
        'model' => 'gpt-4o',
    ]);
});

it('can edit own agent', function (): void {
    $user = User::factory()->create();
    $agent = AiAgent::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Edit::class, ['aiAgent' => $agent])
        ->set('name', 'Updated Name')
        ->call('save')
        ->assertRedirect(route('agents.index'));

    expect($agent->fresh()->name)->toBe('Updated Name');
});

it('can delete own agent', function (): void {
    $user = User::factory()->create();
    $agent = AiAgent::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Index::class)
        ->call('confirmDelete', $agent->id)
        ->call('deleteAgent');

    $this->assertDatabaseMissing('ai_agents', ['id' => $agent->id]);
});

it('cannot edit another users private agent', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $agent = AiAgent::factory()->for($owner)->create(['is_public' => false]);

    Livewire::actingAs($other)
        ->test(\App\Livewire\AiAgents\Edit::class, ['aiAgent' => $agent])
        ->assertForbidden();
});

it('cannot delete another users private agent', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $agent = AiAgent::factory()->for($owner)->create(['is_public' => false]);

    Livewire::actingAs($other)
        ->test(\App\Livewire\AiAgents\Index::class)
        ->call('confirmDelete', $agent->id)
        ->call('deleteAgent')
        ->assertForbidden();
});

it('admin can edit any agent', function (): void {
    $owner = User::factory()->create();
    $admin = User::factory()->admin()->create();
    $agent = AiAgent::factory()->for($owner)->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\AiAgents\Edit::class, ['aiAgent' => $agent])
        ->set('name', 'Admin Updated')
        ->call('save')
        ->assertRedirect(route('agents.index'));

    expect($agent->fresh()->name)->toBe('Admin Updated');
});

it('public agents are visible to all users', function (): void {
    $owner = User::factory()->create();
    $viewer = User::factory()->create();
    $publicAgent = AiAgent::factory()->for($owner)->create(['is_public' => true]);

    $this->actingAs($viewer)
        ->get(route('agents.show', $publicAgent))
        ->assertOk();
});

it('private agents are only visible to owner', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $privateAgent = AiAgent::factory()->for($owner)->create(['is_public' => false]);

    $this->actingAs($other)
        ->get(route('agents.show', $privateAgent))
        ->assertForbidden();
});

it('validates required fields when creating an agent', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Create::class)
        ->set('name', '')
        ->set('system_prompt', '')
        ->call('save')
        ->assertHasErrors(['name', 'system_prompt']);
});

it('updates available models when provider changes', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\AiAgents\Create::class)
        ->set('provider', 'anthropic')
        ->assertSet('model', 'claude-sonnet-4-5-20250929')
        ->assertSet('availableModels', ['claude-sonnet-4-5-20250929', 'claude-haiku-4-5-20251001']);
});
