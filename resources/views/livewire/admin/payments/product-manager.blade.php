<div>
    <div class="flex items-center justify-between mb-4">
        <x-typography.heading accent>{{ __('One-Time Products') }}</x-typography.heading>
        <x-button size="sm" wire:click="createProduct">{{ __('Add Product') }}</x-button>
    </div>

    @if ($products->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Name') }}</x-table-heading>
                <x-table-heading>{{ __('Price') }}</x-table-heading>
                <x-table-heading>{{ __('Stripe Price ID') }}</x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($products as $product)
                <tr wire:key="product-{{ $product->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $product->name }}
                    </x-table-cell>
                    <x-table-cell>{{ $product->formattedPrice() }}</x-table-cell>
                    <x-table-cell class="text-xs">{{ $product->stripe_price_id ?? '-' }}</x-table-cell>
                    <x-table-cell>
                        <x-badge :variant="$product->is_active ? 'success' : 'default'" size="sm">
                            {{ $product->is_active ? __('Active') : __('Inactive') }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" wire:click="editProduct({{ $product->id }})">{{ __('Edit') }}</x-button>
                            <x-button size="xs" variant="ghost" wire:click="toggleActive({{ $product->id }})">
                                {{ $product->is_active ? __('Deactivate') : __('Activate') }}
                            </x-button>
                            <x-button size="xs" variant="ghost" wire:click="confirmDelete({{ $product->id }})" class="text-danger hover:text-danger">
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>
    @else
        <x-empty-state title="{{ __('No products yet') }}" description="{{ __('Create your first product.') }}">
            <x-slot name="action">
                <x-button wire:click="createProduct">{{ __('Add Product') }}</x-button>
            </x-slot>
        </x-empty-state>
    @endif

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-99 flex items-start justify-center bg-surface-dark/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8" role="dialog" aria-modal="true">
            <div class="flex sm:max-w-xl w-full flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                <div class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark-alt/20">
                    <x-typography.heading accent>{{ $editingProductId ? __('Edit Product') : __('Create Product') }}</x-typography.heading>
                    <button wire:click="$set('showModal', false)" class="ml-auto" aria-label="close modal">
                        <x-icons.x-mark />
                    </button>
                </div>
                <form wire:submit="saveProduct" class="p-4 flex flex-col gap-4">
                    <div>
                        <x-input-label value="{{ __('Name') }}" for="product-name" />
                        <x-input id="product-name" type="text" wire:model="name" class="mt-1" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Description') }}" for="product-description" />
                        <textarea id="product-description" wire:model="description" rows="2" class="mt-1 w-full rounded-radius border border-outline bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:focus-visible:outline-primary-dark"></textarea>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label value="{{ __('Price (cents)') }}" for="product-price" />
                            <x-input id="product-price" type="number" wire:model="price" min="0" class="mt-1" />
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label value="{{ __('Stripe Price ID') }}" for="product-stripe-id" />
                            <x-input id="product-stripe-id" type="text" wire:model="stripe_price_id" placeholder="price_..." class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-toggle id="product-active" wire:model="is_active">{{ __('Active') }}</x-toggle>
                    </div>

                    <div class="flex justify-end gap-2">
                        <x-button variant="ghost" type="button" wire:click="$set('showModal', false)">{{ __('Cancel') }}</x-button>
                        <x-button type="submit">{{ $editingProductId ? __('Update Product') : __('Create Product') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingProductId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Product') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this product? This action cannot be undone.') }}
            </p>
        </div>
        <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deleteProduct">{{ __('Delete Product') }}</x-button>
        </div>
    </x-modal>
</div>
