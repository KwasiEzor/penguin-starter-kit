<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Livewire\Concerns\HasToast;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Str;

/**
 * Livewire component for managing blog post categories.
 *
 * Provides CRUD operations for categories including creating, editing,
 * and deleting categories with validation and safeguards against
 * deleting categories that have associated posts.
 */
#[Layout('components.layouts.app')]
final class Index extends Component
{
    use HasToast;

    public bool $showModal = false;

    public ?int $editingCategoryId = null;

    public ?int $deletingCategoryId = null;

    public string $name = '';

    public string $slug = '';

    /**
     * Open the modal form for creating a new category.
     *
     * Resets the form fields and displays the category creation modal.
     *
     * @return void
     */
    public function createCategory(): void
    {
        $this->reset(['editingCategoryId', 'name', 'slug']);
        $this->showModal = true;
    }

    /**
     * Open the modal form for editing an existing category.
     *
     * Loads the category data into the form fields and displays the modal.
     *
     * @param  int  $id  The ID of the category to edit.
     * @return void
     */
    public function editCategory(int $id): void
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->showModal = true;
    }

    /**
     * Auto-generate the slug when the name field is updated during creation.
     *
     * Only generates the slug automatically for new categories, not when editing.
     *
     * @return void
     */
    public function updatedName(): void
    {
        if ($this->editingCategoryId === null) {
            $this->slug = Str::slug($this->name);
        }
    }

    /**
     * Validate and save the category (create or update).
     *
     * Validates the name and slug fields, ensuring slug uniqueness,
     * then creates a new category or updates the existing one.
     *
     * @return void
     */
    public function saveCategory(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->editingCategoryId),
            ],
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        if ($this->editingCategoryId) {
            $category = Category::findOrFail($this->editingCategoryId);
            $category->update($data);
            $this->toastSuccess('Category updated successfully.');
        } else {
            Category::create($data);
            $this->toastSuccess('Category created successfully.');
        }

        $this->showModal = false;
        $this->reset(['editingCategoryId', 'name', 'slug']);
    }

    /**
     * Set the category ID pending deletion to show the confirmation dialog.
     *
     * @param  int  $id  The ID of the category to confirm deletion for.
     * @return void
     */
    public function confirmDelete(int $id): void
    {
        $this->deletingCategoryId = $id;
    }

    /**
     * Cancel the pending category deletion and dismiss the confirmation dialog.
     *
     * @return void
     */
    public function cancelDelete(): void
    {
        $this->deletingCategoryId = null;
    }

    /**
     * Delete the category pending deletion.
     *
     * Prevents deletion if the category has any associated posts.
     *
     * @return void
     */
    public function deleteCategory(): void
    {
        $category = Category::withCount('posts')->findOrFail($this->deletingCategoryId);

        if ($category->posts_count > 0) {
            $this->toastError("Cannot delete category with {$category->posts_count} attached post(s).");
            $this->deletingCategoryId = null;

            return;
        }

        $category->delete();
        $this->deletingCategoryId = null;
        $this->toastSuccess('Category deleted successfully.');
    }

    /**
     * Render the categories index view with all categories and their post counts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::withCount('posts')->orderBy('name')->get(),
        ]);
    }
}
