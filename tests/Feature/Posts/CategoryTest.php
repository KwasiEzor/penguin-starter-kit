<?php

/**
 * Tests for category integration with posts via Livewire components.
 *
 * Covers creating and updating posts with categories, removing categories,
 * displaying categories on the blog show page, filtering posts by category
 * on the index page, loading existing categories in the edit form, and
 * validating that category IDs reference existing records.
 */

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

it('creates a post with categories', function (): void {
    $user = User::factory()->create();
    $categories = Category::factory(2)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Categorized Post')
        ->set('body', 'Post with categories.')
        ->set('status', 'draft')
        ->set('category_ids', $categories->pluck('id')->toArray())
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post = Post::where('title', 'Categorized Post')->first();
    expect($post->categories)->toHaveCount(2);
});

it('updates post categories', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $oldCategories = Category::factory(2)->create();
    $newCategory = Category::factory()->create();
    $post->categories()->sync($oldCategories->pluck('id'));

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('category_ids', [$newCategory->id])
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post->refresh();
    expect($post->categories)->toHaveCount(1);
    expect($post->categories->first()->id)->toBe($newCategory->id);
});

it('removes all categories from a post', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $categories = Category::factory(2)->create();
    $post->categories()->sync($categories->pluck('id'));

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post])
        ->set('category_ids', [])
        ->call('save')
        ->assertRedirect(route('posts.index'));

    $post->refresh();
    expect($post->categories)->toHaveCount(0);
});

it('displays categories on blog show page', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->published()->create();
    $category = Category::factory()->create(['name' => 'Technology']);
    $post->categories()->attach($category);

    $this->get(route('blog.show', $post->slug))
        ->assertOk()
        ->assertSee('Technology');
});

it('filters posts by category on index', function (): void {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Tutorial', 'slug' => 'tutorial']);
    $otherCategory = Category::factory()->create(['name' => 'News', 'slug' => 'news']);

    $postWithCategory = Post::factory()->for($user)->create(['title' => 'Tutorial Post']);
    $postWithCategory->categories()->attach($category);

    $postWithOther = Post::factory()->for($user)->create(['title' => 'News Post']);
    $postWithOther->categories()->attach($otherCategory);

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Index::class)
        ->set('categoryFilter', 'tutorial')
        ->assertSee('Tutorial Post')
        ->assertDontSee('News Post');
});

it('loads existing categories in edit form', function (): void {
    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();
    $categories = Category::factory(2)->create();
    $post->categories()->sync($categories->pluck('id'));

    $component = Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Edit::class, ['post' => $post]);

    expect($component->get('category_ids'))->toHaveCount(2);
});

it('validates category IDs exist', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Posts\Create::class)
        ->set('title', 'Test Post')
        ->set('body', 'Some content.')
        ->set('status', 'draft')
        ->set('category_ids', [99999])
        ->call('save')
        ->assertHasErrors(['category_ids.0']);
});
