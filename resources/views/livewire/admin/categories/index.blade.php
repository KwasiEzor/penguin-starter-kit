<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-breadcrumbs class="mb-4">
                <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
                <x-breadcrumb-item :active="true">{{ __('Categories') }}</x-breadcrumb-item>
            </x-breadcrumbs>

            <x-typography.heading accent size="xl" level="1">{{ __('Categories') }}</x-typography.heading>
            <x-typography.subheading size="lg">{{ __('Manage post categories') }}</x-typography.subheading>
        </div>
        <x-button wire:click="createCategory">{{ __('Add Category') }}</x-button>
    </div>

    <x-separator />

    <!-- Table -->
    @if ($categories->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Name') }}</x-table-heading>
                <x-table-heading>{{ __('Slug') }}</x-table-heading>
                <x-table-heading>{{ __('Posts') }}</x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($categories as $category)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="category-{{ $category->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $category->name }}
                    </x-table-cell>
                    <x-table-cell class="text-xs">{{ $category->slug }}</x-table-cell>
                    <x-table-cell>
                        <x-badge variant="default">{{ $category->posts_count }}</x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" wire:click="editCategory({{ $category->id }})">
                                {{ __('Edit') }}
                            </x-button>
                            <x-button
                                size="xs"
                                variant="ghost"
                                wire:click="confirmDelete({{ $category->id }})"
                                class="text-danger hover:text-danger"
                            >
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>
    @else
        <x-empty-state
            title="{{ __('No categories yet') }}"
            description="{{ __('Create your first category to organize posts.') }}"
        >
            <x-slot name="action">
                <x-button wire:click="createCategory">{{ __('Add Category') }}</x-button>
            </x-slot>
        </x-empty-state>
    @endif

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div
            class="fixed inset-0 z-99 flex items-start justify-center bg-surface-dark/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="flex sm:max-w-xl w-full flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark"
            >
                <div
                    class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark-alt/20"
                >
                    <x-typography.heading accent>
                        {{ $editingCategoryId ? __('Edit Category') : __('Create Category') }}
                    </x-typography.heading>
                    <button wire:click="$set('showModal', false)" class="ml-auto" aria-label="close modal">
                        <x-icons.x-mark />
                    </button>
                </div>
                <form wire:submit="saveCategory" class="p-4 flex flex-col gap-4">
                    <div>
                        <x-input-label value="{{ __('Name') }}" for="category-name" />
                        <x-input id="category-name" type="text" wire:model.live="name" class="mt-1" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Slug') }}" for="category-slug" />
                        <x-input id="category-slug" type="text" wire:model="slug" class="mt-1" />
                        <x-input-error :messages="$errors->get('slug')" class="mt-1" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <x-button variant="ghost" type="button" wire:click="$set('showModal', false)">
                            {{ __('Cancel') }}
                        </x-button>
                        <x-button type="submit">
                            {{ $editingCategoryId ? __('Update Category') : __('Create Category') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingCategoryId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Category') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this category? This action cannot be undone.') }}
            </p>
        </div>
        <div
            class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end"
        >
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deleteCategory">
                {{ __('Delete Category') }}
            </x-button>
        </div>
    </x-modal>
</div>
