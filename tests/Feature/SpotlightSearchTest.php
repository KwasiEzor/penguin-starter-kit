<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('renders the spotlight search component', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->assertSee('Search');
});

it('searches posts by title', function () {
    $user = User::factory()->create();
    Post::factory()->for($user)->create(['title' => 'Laravel Tips']);
    Post::factory()->for($user)->create(['title' => 'Vue Guide']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->set('query', 'Laravel')
        ->assertSee('Laravel Tips')
        ->assertDontSee('Vue Guide');
});

it('shows navigation pages when searching', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->set('query', 'Dash')
        ->assertSee('Dashboard');
});

it('shows no results message for unknown queries', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->set('query', 'zzzznonexistent')
        ->assertSee('No results found');
});

it('only shows the current users posts', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Post::factory()->for($other)->create(['title' => 'Other User Post']);

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->set('query', 'Other User')
        ->assertDontSee('Other User Post');
});

it('can close the search', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\SpotlightSearch::class)
        ->set('query', 'test')
        ->call('close')
        ->assertSet('query', '')
        ->assertSet('open', false);
});
