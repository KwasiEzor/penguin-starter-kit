<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between bg-surface dark:bg-surface-dark p-6 rounded-2xl border border-outline dark:border-outline-dark shadow-sm">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex size-12 items-center justify-center rounded-2xl bg-primary/10 text-primary dark:bg-primary-dark/10 dark:text-primary-dark">
                <x-icons.tag variant="outline" size="md" />
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Categories') }}
                </h1>
                <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-0.5">
                    {{ __('Organize and classify your content with precision.') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative max-w-xs">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <x-icons.magnifying-glass variant="outline" size="xs" class="text-on-surface/40" />
                </div>
                <x-input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search categories..." 
                    class="pl-10 h-11"
                />
            </div>
            <x-button wire:click="createCategory" class="h-11 px-5 shadow-lg shadow-primary/20">
                <x-icons.plus variant="outline" size="sm" class="mr-2" />
                {{ __('New Category') }}
            </x-button>
        </div>
    </div>

    <!-- Main Card -->
    <x-card padding="false" class="overflow-hidden border-none shadow-xl shadow-surface-dark/5">
        @if ($categories->count() || $search)
            <div class="overflow-x-auto">
                <x-table>
                    <x-slot name="head">
                        <x-table-heading class="w-12 text-center">#</x-table-heading>
                        <x-table-heading>{{ __('Category') }}</x-table-heading>
                        <x-table-heading>{{ __('Slug') }}</x-table-heading>
                        <x-table-heading>{{ __('Posts') }}</x-table-heading>
                        <x-table-heading>{{ __('Created') }}</x-table-heading>
                        <x-table-heading class="text-right">{{ __('Actions') }}</x-table-heading>
                    </x-slot>

                    @forelse ($categories as $category)
                        <tr class="group hover:bg-surface-alt/30 dark:hover:bg-surface-dark/30 transition-all duration-200" wire:key="category-{{ $category->id }}">
                            <x-table-cell class="text-center">
                                <div class="size-3 rounded-full mx-auto shadow-sm border border-black/5" style="background-color: {{ $category->color ?? '#3b82f6' }}"></div>
                            </x-table-cell>
                            <x-table-cell>
                                <div class="flex flex-col">
                                    <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong group-hover:text-primary transition-colors">
                                        {{ $category->name }}
                                    </span>
                                    @if($category->description)
                                        <span class="text-xs text-on-surface/50 line-clamp-1 max-w-xs font-medium">
                                            {{ $category->description }}
                                        </span>
                                    @endif
                                </div>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-surface-alt dark:bg-surface-dark text-on-surface/70 border border-outline dark:border-outline-dark">
                                    {{ $category->slug }}
                                </span>
                            </x-table-cell>
                            <x-table-cell>
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-1 overflow-hidden">
                                        <div class="size-6 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary border-2 border-surface dark:border-surface-dark">
                                            {{ $category->posts_count }}
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface/40 uppercase tracking-wider">{{ __('Posts') }}</span>
                                </div>
                            </x-table-cell>
                            <x-table-cell class="text-on-surface/60 text-sm font-medium">
                                {{ $category->created_at->format('M d, Y') }}
                            </x-table-cell>
                            <x-table-cell>
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        type="button"
                                        wire:click="editCategory({{ $category->id }})"
                                        class="flex size-9 items-center justify-center rounded-xl text-on-surface/40 transition-all hover:bg-primary/10 hover:text-primary dark:hover:bg-primary-dark/10 dark:hover:text-primary-dark"
                                        title="{{ __('Edit Category') }}"
                                    >
                                        <x-icons.pencil-square variant="outline" size="sm" />
                                    </button>
                                    @if ($category->posts_count === 0)
                                        <button
                                            type="button"
                                            wire:click="confirmDelete({{ $category->id }})"
                                            class="flex size-9 items-center justify-center rounded-xl text-on-surface/40 transition-all hover:bg-danger/10 hover:text-danger"
                                            title="{{ __('Delete Category') }}"
                                        >
                                            <x-icons.trash variant="outline" size="sm" />
                                        </button>
                                    @else
                                        <div class="size-9 flex items-center justify-center text-on-surface/20 cursor-not-allowed" title="{{ __('Cannot delete category with posts') }}">
                                            <x-icons.shield variant="outline" size="sm" />
                                        </div>
                                    @endif
                                </div>
                            </x-table-cell>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="flex flex-col items-center justify-center py-24">
                                    <div class="bg-surface-alt dark:bg-surface-dark rounded-3xl p-8 mb-6 shadow-inner">
                                        <x-icons.magnifying-glass variant="outline" size="xl" class="text-on-surface/10" />
                                    </div>
                                    <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                        {{ __('No results found') }}
                                    </h3>
                                    <p class="text-on-surface/60 max-w-xs text-center mt-2 font-medium">
                                        {{ __('We couldn\'t find any categories matching ":search"', ['search' => $search]) }}
                                    </p>
                                    <x-button variant="ghost" wire:click="$set('search', '')" class="mt-6">
                                        {{ __('Clear search') }}
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <x-slot name="mobile">
                        @forelse ($categories as $category)
                            <div class="bg-surface dark:bg-surface-dark p-4 rounded-xl border border-outline dark:border-outline-dark space-y-4" wire:key="category-mobile-{{ $category->id }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="size-3 rounded-full shadow-sm border border-black/5" style="background-color: {{ $category->color ?? '#3b82f6' }}"></div>
                                        <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $category->name }}</span>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-primary/10 text-primary">
                                        {{ $category->posts_count }} {{ __('POSTS') }}
                                    </span>
                                </div>
                                
                                @if($category->description)
                                    <p class="text-xs text-on-surface/60 line-clamp-2 italic">{{ $category->description }}</p>
                                @endif

                                <div class="flex items-center justify-between pt-2 border-t border-outline/50 dark:border-outline-dark/50">
                                    <code class="text-[10px] font-mono text-on-surface/40 italic">{{ $category->slug }}</code>
                                    <div class="flex items-center gap-2">
                                        <x-button variant="ghost" size="sm" wire:click="editCategory({{ $category->id }})" class="size-8 p-0 rounded-lg">
                                            <x-icons.pencil-square variant="outline" size="xs" />
                                        </x-button>
                                        @if ($category->posts_count === 0)
                                            <x-button variant="ghost" size="sm" wire:click="confirmDelete({{ $category->id }})" class="size-8 p-0 rounded-lg text-danger hover:bg-danger/10">
                                                <x-icons.trash variant="outline" size="xs" />
                                            </x-button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-on-surface/40 text-sm font-medium">{{ __('No categories found.') }}</p>
                            </div>
                        @endforelse
                    </x-slot>
                </x-table>
            </div>
            
            @if($categories->hasPages())
                <div class="p-6 border-t border-outline dark:border-outline-dark bg-surface-alt/30 dark:bg-surface-dark-alt/10">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="flex flex-col items-center justify-center py-32">
                <div class="relative mb-8">
                    <div class="absolute -inset-4 bg-primary/5 rounded-full blur-2xl animate-pulse"></div>
                    <div class="relative bg-gradient-to-br from-surface-alt to-surface dark:from-surface-dark dark:to-surface-dark-alt rounded-3xl p-10 border border-outline dark:border-outline-dark shadow-xl">
                        <x-icons.tag variant="outline" class="size-16 text-primary/40" />
                    </div>
                </div>
                <h3 class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('Your Category Collection is Empty') }}
                </h3>
                <p class="text-on-surface/60 max-w-md text-center mt-3 font-medium text-lg leading-relaxed">
                    {{ __('Start organizing your blog and AI agents by creating your very first category today.') }}
                </p>
                <x-button wire:click="createCategory" class="mt-10 h-14 px-8 text-lg shadow-xl shadow-primary/25 rounded-2xl">
                    <x-icons.plus variant="outline" size="md" class="mr-2" />
                    {{ __('Create My First Category') }}
                </x-button>
            </div>
        @endif
    </x-card>

    <!-- Create/Edit Modal -->
    <x-modal wire:model="showModal" maxWidth="lg">
        <x-slot:header>
            <div class="flex items-center gap-3">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    @if($editingCategoryId)
                        <x-icons.pencil-square variant="outline" size="sm" />
                    @else
                        <x-icons.plus variant="outline" size="sm" />
                    @endif
                </div>
                <h3 class="text-xl font-black text-on-surface-strong dark:text-on-surface-dark-strong uppercase tracking-tight">
                    {{ $editingCategoryId ? __('Edit Category') : __('Create New Category') }}
                </h3>
            </div>
        </x-slot:header>

        <form wire:submit="saveCategory" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6 md:col-span-1">
                    <div>
                        <x-input-label for="name" :value="__('Display Name')" class="text-xs uppercase tracking-widest font-bold text-on-surface/40 mb-2" />
                        <x-input id="name" type="text" class="h-12 text-lg font-bold" wire:model.live="name" required autofocus placeholder="e.g. Technology" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="slug" :value="__('URL Slug')" class="text-xs uppercase tracking-widest font-bold text-on-surface/40 mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-on-surface/30 text-sm font-mono">
                                /
                            </div>
                            <x-input id="slug" type="text" class="h-12 pl-6 font-mono text-sm" wire:model="slug" placeholder="technology" />
                        </div>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        <p class="text-[10px] mt-2 text-on-surface/40 italic">{{ __('Automatically generated from the name for SEO optimization.') }}</p>
                    </div>

                    <div>
                        <x-input-label for="color" :value="__('Brand Color')" class="text-xs uppercase tracking-widest font-bold text-on-surface/40 mb-2" />
                        <div class="flex items-center gap-3">
                            <div class="relative size-12 rounded-2xl overflow-hidden border-2 border-outline dark:border-outline-dark shadow-sm shrink-0">
                                <input 
                                    type="color" 
                                    wire:model.live="color" 
                                    class="absolute -inset-2 size-16 cursor-pointer bg-transparent border-none p-0"
                                />
                            </div>
                            <x-input id="color" type="text" class="h-12 font-mono uppercase text-center w-32" wire:model.live="color" maxlength="7" />
                        </div>
                        <x-input-error :messages="$errors->get('color')" class="mt-2" />
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6 md:col-span-1">
                    <div>
                        <x-input-label for="description" :value="__('Description')" class="text-xs uppercase tracking-widest font-bold text-on-surface/40 mb-2" />
                        <textarea 
                            id="description" 
                            wire:model="description" 
                            rows="8"
                            class="w-full rounded-2xl border-outline bg-surface-alt/50 text-on-surface transition-all focus:border-primary focus:ring-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark placeholder:text-on-surface/20"
                            placeholder="Briefly describe what this category covers..."
                        ></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <div class="flex justify-between mt-2">
                            <p class="text-[10px] text-on-surface/40">{{ __('Used for SEO and meta descriptions.') }}</p>
                            <p class="text-[10px] text-on-surface/40">{{ strlen($description) }}/1000</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end gap-4 border-t border-outline dark:border-outline-dark pt-8">
                <x-button variant="ghost" type="button" wire:click="resetForm" class="h-12 px-8 font-bold">{{ __('Cancel') }}</x-button>
                <x-button type="submit" class="h-12 px-10 shadow-xl shadow-primary/20 rounded-xl font-bold">
                    @if($editingCategoryId)
                        <x-icons.check variant="outline" size="sm" class="mr-2" />
                        {{ __('Save Changes') }}
                    @else
                        <x-icons.plus variant="outline" size="sm" class="mr-2" />
                        {{ __('Create Category') }}
                    @endif
                </x-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" maxWidth="md">
        <div class="p-10 text-center">
            <div class="mx-auto flex size-20 items-center justify-center rounded-3xl bg-danger/10 text-danger mb-6">
                <x-icons.trash variant="outline" class="size-10" />
            </div>
            
            <h3 class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong mb-2">
                {{ __('Delete Category?') }}
            </h3>
            <p class="text-on-surface/60 font-medium mb-8">
                {{ __('Are you sure you want to delete ":name"? This action is irreversible.', ['name' => $deletingCategoryName]) }}
            </p>

            <div class="flex flex-col gap-3">
                <x-button variant="danger" type="button" wire:click="deleteCategory" class="w-full h-14 rounded-2xl text-lg font-bold shadow-lg shadow-danger/20">
                    {{ __('Yes, Delete Category') }}
                </x-button>
                <x-button variant="ghost" type="button" wire:click="cancelDelete" class="w-full h-12 font-bold">
                    {{ __('No, Keep It') }}
                </x-button>
            </div>
        </div>
    </x-modal>
</div>
