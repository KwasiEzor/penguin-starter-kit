<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Category Manager') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Organize your posts and content with polymorphic categories.') }}
            </p>
        </div>
        <x-button wire:click="createCategory" class="shadow-lg shadow-primary/20">
            <x-icons.plus variant="outline" size="sm" class="mr-1" />
            {{ __('New Category') }}
        </x-button>
    </div>

    <!-- Main Card -->
    <x-card padding="false">
        @if ($categories->count())
            <x-table>
                <x-slot name="head">
                    <x-table-heading>{{ __('Name') }}</x-table-heading>
                    <x-table-heading>{{ __('Slug') }}</x-table-heading>
                    <x-table-heading>{{ __('Post Count') }}</x-table-heading>
                    <x-table-heading class="text-right">{{ __('Actions') }}</x-table-heading>
                </x-slot>

                @foreach ($categories as $category)
                    <tr class="group hover:bg-surface-alt/30 dark:hover:bg-surface-dark/30 transition-colors" wire:key="category-{{ $category->id }}">
                        <x-table-cell>
                            <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ $category->name }}
                            </span>
                        </x-table-cell>
                        <x-table-cell>
                            <code class="text-xs bg-surface-alt dark:bg-surface-dark px-2 py-1 rounded border border-outline dark:border-outline-dark text-on-surface/70">
                                {{ $category->slug }}
                            </code>
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center gap-2">
                                <x-icons.document-text variant="outline" size="xs" class="text-on-surface/40" />
                                <span class="text-sm font-semibold text-on-surface/70">{{ number_format($category->posts_count) }}</span>
                            </div>
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    wire:click="editCategory({{ $category->id }})"
                                    class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-primary/10 hover:text-primary dark:hover:bg-primary-dark/10 dark:hover:text-primary-dark"
                                    title="{{ __('Edit Category') }}"
                                >
                                    <x-icons.pencil-square variant="outline" size="sm" />
                                </button>
                                @if ($category->posts_count === 0)
                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $category->id }})"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-danger/10 hover:text-danger"
                                        title="{{ __('Delete Category') }}"
                                    >
                                        <x-icons.trash variant="outline" size="sm" />
                                    </button>
                                @endif
                            </div>
                        </x-table-cell>
                    </tr>
                @endforeach
            </x-table>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="bg-surface-alt dark:bg-surface-dark rounded-full p-6 mb-4">
                    <x-icons.tag variant="outline" size="xl" class="text-on-surface/20" />
                </div>
                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('No categories yet') }}
                </h3>
                <p class="text-on-surface/60 max-w-xs text-center mt-1">
                    {{ __('Organize your blog and agents by creating your first category.') }}
                </p>
                <x-button wire:click="createCategory" class="mt-6 shadow-lg shadow-primary/20">
                    {{ __('Create Category') }}
                </x-button>
            </div>
        @endif
    </x-card>

    @teleport('body')
        <!-- Create/Edit Modal -->
        <x-modal :show="$showModal" maxWidth="md">
            <x-slot:header>
                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ $editingCategoryId ? __('Edit Category') : __('New Category') }}
                </h3>
            </x-slot:header>

            <form wire:submit="saveCategory" class="p-6">
                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input id="name" type="text" class="mt-1" wire:model.live="name" required autofocus placeholder="e.g. Technology" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="slug" :value="__('Slug (Optional)')" />
                        <x-input id="slug" type="text" class="mt-1" wire:model="slug" placeholder="e.g. technology" />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        <p class="text-[10px] mt-1 text-on-surface/40 italic">{{ __('The "slug" is the URL-friendly version of the name.') }}</p>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <x-button variant="ghost" type="button" wire:click="resetForm">{{ __('Cancel') }}</x-button>
                    <x-button type="submit" class="shadow-md shadow-primary/20">
                        <x-icons.check variant="outline" size="sm" class="mr-1" />
                        {{ __('Save Category') }}
                    </x-button>
                </div>
            </form>
        </x-modal>

        <!-- Delete Confirmation Modal -->
        <x-modal :show="$deletingCategoryId !== null" maxWidth="md">
            <x-slot:header>
                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Delete Category') }}
                </h3>
            </x-slot:header>

            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex size-12 items-center justify-center rounded-full bg-danger/10 text-danger">
                        <x-icons.trash variant="outline" size="md" />
                    </div>
                    <div>
                        <h4 class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ __('Confirm Deletion') }}
                        </h4>
                        <p class="text-xs text-on-surface/60">{{ __('This action cannot be undone.') }}</p>
                    </div>
                </div>
                
                <p class="text-on-surface dark:text-on-surface-dark mb-8 leading-relaxed">
                    {!! __('Are you sure you want to delete the category **:name**? It will be removed from all associated content.', ['name' => $deletingCategoryName]) !!}
                </p>

                <div class="flex items-center justify-end gap-3">
                    <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
                    <x-button variant="danger" type="button" wire:click="deleteCategory">{{ __('Delete Category') }}</x-button>
                </div>
            </div>
        </x-modal>
    @endteleport
</div>
