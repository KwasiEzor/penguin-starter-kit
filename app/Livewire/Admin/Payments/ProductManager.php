<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Payments;

use App\Livewire\Concerns\HasToast;
use App\Models\Product;
use Livewire\Component;

final class ProductManager extends Component
{
    use HasToast;

    public bool $showModal = false;

    public ?int $editingProductId = null;

    public ?int $deletingProductId = null;

    public string $name = '';

    public string $description = '';

    public int $price = 0;

    public string $stripe_price_id = '';

    public bool $is_active = true;

    public function createProduct(): void
    {
        $this->reset(['editingProductId', 'name', 'description', 'price', 'stripe_price_id', 'is_active']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function editProduct(int $id): void
    {
        $product = Product::findOrFail($id);
        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->price = $product->price;
        $this->stripe_price_id = $product->stripe_price_id ?? '';
        $this->is_active = $product->is_active;
        $this->showModal = true;
    }

    public function saveProduct(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stripe_price_id' => ['nullable', 'string', 'max:255'],
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'stripe_price_id' => $this->stripe_price_id ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($data);
            $this->toastSuccess('Product updated successfully.');
        } else {
            Product::create($data);
            $this->toastSuccess('Product created successfully.');
        }

        $this->showModal = false;
        $this->reset(['editingProductId', 'name', 'description', 'price', 'stripe_price_id', 'is_active']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingProductId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingProductId = null;
    }

    public function deleteProduct(): void
    {
        Product::findOrFail($this->deletingProductId)->delete();
        $this->deletingProductId = null;
        $this->toastSuccess('Product deleted successfully.');
    }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);
        $this->toastSuccess($product->is_active ? 'Product activated.' : 'Product deactivated.');
    }

    public function render()
    {
        return view('livewire.admin.payments.product-manager', [
            'products' => Product::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }
}
