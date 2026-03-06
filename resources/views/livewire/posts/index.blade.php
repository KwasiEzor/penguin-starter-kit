<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Your Content') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Manage your blog posts, articles, and announcements.') }}
            </p>
        </div>
        <x-button href="{{ route('posts.create') }}" class="shadow-lg shadow-primary/20">
            <x-icons.plus variant="outline" size="sm" class="mr-1" />
            {{ __('New Publication') }}
        </x-button>
    </div>

    <!-- Toolbar: Search & Filters -->
    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <x-icons.magnifying-glass variant="outline" size="sm" class="text-on-surface/40" />
                </div>
                <x-input 
                    type="search" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="{{ __('Search by title or excerpt...') }}" 
                    class="pl-11 !bg-surface border-transparent shadow-sm focus:!bg-surface"
                />
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <div class="w-40">
                    <x-select wire:model.live="statusFilter" class="!bg-surface border-transparent shadow-sm">
                        <option value="">{{ __('Any Status') }}</option>
                        <option value="draft">{{ __('Drafts') }}</option>
                        <option value="published">{{ __('Published') }}</option>
                    </x-select>
                </div>

                @if ($availableCategories->isNotEmpty())
                    <div class="w-48">
                        <x-select wire:model.live="categoryFilter" class="!bg-surface border-transparent shadow-sm">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach ($availableCategories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                @endif
            </div>
        </div>

        @if (! empty($availableTags))
            <div class="flex items-center gap-2 overflow-x-auto pb-2 -mb-2 no-scrollbar">
                <span class="text-[10px] font-black uppercase tracking-widest text-on-surface/40 mr-2 whitespace-nowrap">{{ __('Popular Tags') }}:</span>
                <button 
                    wire:click="$set('tagFilter', '')"
                    @class([
                        'px-3 py-1 rounded-full text-xs font-bold transition-all whitespace-nowrap',
                        'bg-primary text-white shadow-md shadow-primary/20' => $tagFilter === '',
                        'bg-surface text-on-surface/60 hover:bg-surface-alt' => $tagFilter !== '',
                    ])
                >
                    {{ __('All') }}
                </button>
                @foreach (array_slice($availableTags, 0, 8) as $tag)
                    <button 
                        wire:click="$set('tagFilter', '{{ $tag }}')"
                        @class([
                            'px-3 py-1 rounded-full text-xs font-bold transition-all whitespace-nowrap',
                            'bg-primary text-white shadow-md shadow-primary/20' => $tagFilter === $tag,
                            'bg-surface text-on-surface/60 hover:bg-surface-alt' => $tagFilter !== $tag,
                        ])
                    >
                        #{{ $tag }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Posts Grid -->
    @if ($posts->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($posts as $post)
                <div class="group flex flex-col overflow-hidden rounded-3xl border border-outline bg-surface shadow-premium transition-all duration-300 hover:shadow-xl hover:-translate-y-1 dark:border-outline-dark dark:bg-surface-dark-alt" wire:key="post-{{ $post->id }}">
                    <!-- Featured Image Area -->
                    <div class="relative aspect-video overflow-hidden bg-surface-alt dark:bg-surface-dark">
                        @if ($post->featuredImageUrl())
                            <img src="{{ $post->featuredImageUrl() }}" class="size-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        @else
                            <div class="flex size-full items-center justify-center text-on-surface/10">
                                <x-icons.document-text variant="outline" size="xl" />
                            </div>
                        @endif
                        
                        <!-- Status Badge Overlay -->
                        <div class="absolute left-4 top-4">
                            <x-badge 
                                :variant="$post->status === 'published' ? 'success' : 'default'" 
                                size="sm"
                                class="!bg-white/90 !backdrop-blur dark:!bg-black/60 shadow-sm"
                            >
                                {{ ucfirst($post->status) }}
                            </x-badge>
                        </div>

                        <!-- Action Overlay -->
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('posts.edit', $post) }}" class="size-10 flex items-center justify-center rounded-xl bg-white text-black hover:bg-primary hover:text-white transition-colors">
                                <x-icons.pencil-square size="sm" />
                            </a>
                            <button wire:click="confirmDelete({{ $post->id }})" class="size-10 flex items-center justify-center rounded-xl bg-white text-danger hover:bg-danger hover:text-white transition-colors">
                                <x-icons.trash size="sm" />
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex flex-1 flex-col p-6">
                        <div class="flex items-center gap-2 mb-3">
                            @foreach($post->categories->take(1) as $category)
                                <span class="text-[10px] font-black uppercase tracking-widest text-primary">{{ $category->name }}</span>
                            @endforeach
                            <span class="text-[10px] font-bold text-on-surface/30">&bull;</span>
                            <span class="text-[10px] font-bold text-on-surface/40 uppercase tracking-widest">{{ $post->created_at->format('M d') }}</span>
                        </div>

                        <h3 class="mb-2 line-clamp-2 text-lg font-black leading-tight text-on-surface-strong dark:text-on-surface-dark-strong group-hover:text-primary transition-colors">
                            {{ $post->title }}
                        </h3>
                        
                        @if($post->excerpt)
                            <p class="mb-4 line-clamp-2 text-sm text-on-surface/60 leading-relaxed">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-outline/50 dark:border-outline-dark/50">
                            <div class="flex -space-x-2">
                                @foreach($post->tags->take(3) as $tag)
                                    <div class="size-6 rounded-full bg-surface-alt border-2 border-surface dark:bg-surface-dark dark:border-surface-dark-alt flex items-center justify-center text-[8px] font-bold text-on-surface/60" title="#{{ $tag->name }}">
                                        {{ substr($tag->name, 0, 1) }}
                                    </div>
                                @endforeach
                            </div>
                            
                            <a href="{{ route('posts.edit', $post) }}" class="text-xs font-bold text-on-surface/40 hover:text-primary transition-colors flex items-center gap-1">
                                {{ __('Edit') }}
                                <x-icons.chevron-right size="xs" />
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <x-card class="py-20">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="bg-surface-alt dark:bg-surface-dark rounded-full p-8 mb-6">
                    <x-icons.document-text variant="outline" size="xl" class="text-on-surface/20" />
                </div>
                <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('No publications found') }}
                </h3>
                <p class="text-on-surface/60 max-w-sm mt-2 leading-relaxed">
                    {{ $search || $statusFilter || $tagFilter || $categoryFilter ? __('We couldn\'t find any posts matching your current filters.') : __('Start your journey by creating your first blog post or article.') }}
                </p>
                <div class="mt-8 flex gap-3">
                    @if($search || $statusFilter || $tagFilter || $categoryFilter)
                        <x-button variant="ghost" wire:click="$set('search', ''); $set('statusFilter', ''); $set('tagFilter', ''); $set('categoryFilter', '');">
                            {{ __('Clear All Filters') }}
                        </x-button>
                    @endif
                    <x-button href="{{ route('posts.create') }}" class="shadow-lg shadow-primary/20">
                        {{ __('Create First Post') }}
                    </x-button>
                </div>
            </div>
        </x-card>
    @endif

    <!-- Delete Modal -->
    <x-modal :show="$deletingPostId !== null" maxWidth="md">
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex size-12 items-center justify-center rounded-full bg-danger/10 text-danger">
                    <x-icons.trash variant="outline" size="md" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Delete Publication') }}
                    </h3>
                    <p class="text-sm text-on-surface/60">{{ __('This action is permanent.') }}</p>
                </div>
            </div>
            
            <p class="text-on-surface dark:text-on-surface-dark mb-8 leading-relaxed">
                {{ __('Are you sure you want to delete this post? It will be removed from your public blog and all associated media will be deleted.') }}
            </p>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
                <x-button variant="danger" type="button" wire:click="deletePost">{{ __('Delete Permanently') }}</x-button>
            </div>
        </div>
    </x-modal>
</div>
