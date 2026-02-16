<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

it('deletes the user account with correct password', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('deletePassword', 'password')
        ->call('deleteAccount')
        ->assertRedirect(route('home'));

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
    $this->assertGuest();
});

it('fails to delete account with wrong password', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('deletePassword', 'wrong-password')
        ->call('deleteAccount')
        ->assertHasErrors('deletePassword');

    $this->assertDatabaseHas('users', ['id' => $user->id]);
});
