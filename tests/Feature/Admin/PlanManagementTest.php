<?php

use App\Models\Plan;
use App\Models\User;
use Livewire\Livewire;

it('can create a plan', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\PlanManager::class)
        ->call('createPlan')
        ->set('name', 'Pro Plan')
        ->set('description', 'The pro plan')
        ->set('price', 1999)
        ->set('stripe_price_id', 'price_test_123')
        ->set('interval', 'month')
        ->set('featuresText', "Feature 1\nFeature 2")
        ->set('is_active', true)
        ->set('is_featured', false)
        ->call('savePlan')
        ->assertHasNoErrors();

    $plan = Plan::where('name', 'Pro Plan')->first();
    expect($plan)->not->toBeNull();
    expect($plan->slug)->toBe('pro-plan');
    expect($plan->price)->toBe(1999);
    expect($plan->features)->toBe(['Feature 1', 'Feature 2']);
});

it('can update a plan', function (): void {
    $admin = User::factory()->admin()->create();
    $plan = Plan::factory()->create(['name' => 'Old Name']);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\PlanManager::class)
        ->call('editPlan', $plan->id)
        ->set('name', 'New Name')
        ->call('savePlan')
        ->assertHasNoErrors();

    expect($plan->fresh()->name)->toBe('New Name');
});

it('can delete a plan', function (): void {
    $admin = User::factory()->admin()->create();
    $plan = Plan::factory()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\PlanManager::class)
        ->call('confirmDelete', $plan->id)
        ->call('deletePlan');

    expect(Plan::find($plan->id))->toBeNull();
});

it('can toggle plan active status', function (): void {
    $admin = User::factory()->admin()->create();
    $plan = Plan::factory()->create(['is_active' => true]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\PlanManager::class)
        ->call('toggleActive', $plan->id);

    expect($plan->fresh()->is_active)->toBeFalse();
});

it('auto-generates slug from name', function (): void {
    $plan = Plan::create([
        'name' => 'Enterprise Plan',
        'price' => 9999,
    ]);

    expect($plan->slug)->toBe('enterprise-plan');
});

it('validates required fields when creating plan', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\PlanManager::class)
        ->call('createPlan')
        ->set('name', '')
        ->call('savePlan')
        ->assertHasErrors('name');
});
