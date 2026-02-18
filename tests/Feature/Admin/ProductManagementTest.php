<?php

use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

it('can create a product', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\ProductManager::class)
        ->call('createProduct')
        ->set('name', 'E-Book')
        ->set('description', 'A great e-book')
        ->set('price', 4999)
        ->set('stripe_price_id', 'price_test_456')
        ->set('is_active', true)
        ->call('saveProduct')
        ->assertHasNoErrors();

    $product = Product::where('name', 'E-Book')->first();
    expect($product)->not->toBeNull();
    expect($product->slug)->toBe('e-book');
    expect($product->price)->toBe(4999);
});

it('can update a product', function () {
    $admin = User::factory()->admin()->create();
    $product = Product::factory()->create(['name' => 'Old Product']);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\ProductManager::class)
        ->call('editProduct', $product->id)
        ->set('name', 'Updated Product')
        ->call('saveProduct')
        ->assertHasNoErrors();

    expect($product->fresh()->name)->toBe('Updated Product');
});

it('can delete a product', function () {
    $admin = User::factory()->admin()->create();
    $product = Product::factory()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\ProductManager::class)
        ->call('confirmDelete', $product->id)
        ->call('deleteProduct');

    expect(Product::find($product->id))->toBeNull();
});

it('can toggle product active status', function () {
    $admin = User::factory()->admin()->create();
    $product = Product::factory()->create(['is_active' => true]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Payments\ProductManager::class)
        ->call('toggleActive', $product->id);

    expect($product->fresh()->is_active)->toBeFalse();
});
