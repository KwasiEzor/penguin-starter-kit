<?php

use App\Livewire\Admin\Categories\Index;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('allows admin to access categories page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.categories.index'))
        ->assertOk()
        ->assertSee('Categories');
});

it('forbids non-admin from accessing categories page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.categories.index'))
        ->assertForbidden();
});

it('can create a category with auto-generated slug', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('createCategory')
        ->assertSet('showModal', true)
        ->set('name', 'My New Category')
        ->assertSet('slug', 'my-new-category')
        ->call('saveCategory')
        ->assertHasNoErrors()
        ->assertSet('showModal', false);

    $this->assertDatabaseHas('categories', [
        'name' => 'My New Category',
        'slug' => 'my-new-category',
    ]);
});

it('can update a category', function (): void {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create(['name' => 'Old Name', 'slug' => 'old-name']);

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('editCategory', $category->id)
        ->assertSet('showModal', true)
        ->assertSet('name', 'Old Name')
        ->assertSet('slug', 'old-name')
        ->set('name', 'New Name')
        ->set('slug', 'new-name')
        ->call('saveCategory')
        ->assertHasNoErrors()
        ->assertSet('showModal', false);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'New Name',
        'slug' => 'new-name',
    ]);
});

it('can delete a category with no posts', function (): void {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('confirmDelete', $category->id)
        ->assertSet('deletingCategoryId', $category->id)
        ->call('deleteCategory')
        ->assertSet('deletingCategoryId', null);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

it('cannot delete a category that has posts attached', function (): void {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create(['user_id' => $admin->id]);
    $post->categories()->attach($category->id);

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('confirmDelete', $category->id)
        ->call('deleteCategory')
        ->assertDispatched('notify');

    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

it('validates required fields', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('createCategory')
        ->set('name', '')
        ->set('slug', '')
        ->call('saveCategory')
        ->assertHasErrors(['name', 'slug']);
});

it('validates unique slug', function (): void {
    $admin = User::factory()->admin()->create();
    Category::factory()->create(['slug' => 'existing-slug']);

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('createCategory')
        ->set('name', 'Test')
        ->set('slug', 'existing-slug')
        ->call('saveCategory')
        ->assertHasErrors(['slug']);
});

it('allows same slug when editing the same category', function (): void {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create(['name' => 'Test', 'slug' => 'test']);

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('editCategory', $category->id)
        ->call('saveCategory')
        ->assertHasNoErrors();
});

it('can cancel delete', function (): void {
    $admin = User::factory()->admin()->create();
    $category = Category::factory()->create();

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->call('confirmDelete', $category->id)
        ->assertSet('deletingCategoryId', $category->id)
        ->call('cancelDelete')
        ->assertSet('deletingCategoryId', null);

    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});
