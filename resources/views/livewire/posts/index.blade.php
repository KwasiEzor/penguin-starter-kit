<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-typography.heading accent size="xl" level="1">{{ __('Posts') }}</x-typography.heading>
            <x-typography.subheading size="lg">{{ __('Manage your blog posts') }}</x-typography.subheading>
        </div>
        <x-button href="{{ route('posts.create') }}">{{ __('Create Post') }}</x-button>
    </div>

    <x-separator />

    <!-- Filters -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="flex-1">
            <x-input type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search posts...') }}" />
        </div>
        <div class="w-full sm:w-40">
            <x-select wire:model.live="statusFilter">
                <option value="">{{ __('All Status') }}</option>
                <option value="draft">{{ __('Draft') }}</option>
                <option value="published">{{ __('Published') }}</option>
            </x-select>
        </div>
        @if (! empty($availableTags))
            <div class="w-full sm:w-40">
                <x-select wire:model.live="tagFilter">
                    <option value="">{{ __('All Tags') }}</option>
                    @foreach ($availableTags as $tag)
                        <option value="{{ $tag }}">{{ $tag }}</option>
                    @endforeach
                </x-select>
            </div>
        @endif
        @if ($availableCategories->isNotEmpty())
            <div class="w-full sm:w-40">
                <x-select wire:model.live="categoryFilter">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach ($availableCategories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>
        @endif
    </div>

    <!-- Table -->
    @if ($posts->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Image') }}</x-table-heading>
                <x-table-heading
                    :sortable="true"
                    :direction="$sortBy === 'title' ? $sortDirection : null"
                    wire:click="sortBy('title')"
                >
                    {{ __('Title') }}
                </x-table-heading>
                <x-table-heading>{{ __('Tags') }}</x-table-heading>
                <x-table-heading>{{ __('Categories') }}</x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading
                    :sortable="true"
                    :direction="$sortBy === 'created_at' ? $sortDirection : null"
                    wire:click="sortBy('created_at')"
                >
                    {{ __('Created') }}
                </x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($posts as $post)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="post-{{ $post->id }}">
                    <x-table-cell>
                        @if ($post->featuredImageUrl())
                            <img
                                src="{{ $post->featuredImageUrl() }}"
                                alt=""
                                class="size-10 rounded-radius object-cover"
                            />
                        @else
                            <div
                                class="flex size-10 items-center justify-center rounded-radius bg-surface-alt dark:bg-surface-dark-alt"
                            >
                                <x-icons.document-text
                                    variant="outline"
                                    size="sm"
                                    class="text-on-surface/40 dark:text-on-surface-dark/40"
                                />
                            </div>
                        @endif
                    </x-table-cell>
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $post->title }}
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($post->tags as $tag)
                                <x-badge size="sm" variant="info">{{ $tag->name }}</x-badge>
                            @endforeach
                        </div>
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($post->categories as $category)
                                <x-badge size="sm" variant="default">{{ $category->name }}</x-badge>
                            @endforeach
                        </div>
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge :variant="$post->status === 'published' ? 'success' : 'default'">
                            {{ ucfirst($post->status) }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        {{ $post->created_at->format('M d, Y') }}
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-1">
                            <a
                                href="{{ route('posts.edit', $post) }}"
                                class="inline-flex items-center justify-center rounded-radius p-1.5 text-on-surface transition-colors hover:bg-surface-alt hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-surface-dark-alt dark:hover:text-on-surface-dark-strong"
                                title="{{ __('Edit') }}"
                            >
                                <x-icons.pencil-square variant="outline" size="sm" />
                            </a>
                            <button
                                type="button"
                                wire:click="confirmDelete({{ $post->id }})"
                                class="inline-flex items-center justify-center rounded-radius p-1.5 text-danger transition-colors hover:bg-danger/10"
                                title="{{ __('Delete') }}"
                            >
                                <x-icons.trash variant="outline" size="sm" />
                            </button>
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach

            <x-slot name="mobile">
                @foreach ($posts as $post)
                    <div
                        class="rounded-radius border border-outline bg-surface p-4 dark:border-outline-dark dark:bg-surface-dark"
                        wire:key="post-mobile-{{ $post->id }}"
                    >
                        <div class="flex items-start gap-3">
                            @if ($post->featuredImageUrl())
                                <img
                                    src="{{ $post->featuredImageUrl() }}"
                                    alt=""
                                    class="size-12 shrink-0 rounded-radius object-cover"
                                />
                            @else
                                <div
                                    class="flex size-12 shrink-0 items-center justify-center rounded-radius bg-surface-alt dark:bg-surface-dark-alt"
                                >
                                    <x-icons.document-text
                                        variant="outline"
                                        size="sm"
                                        class="text-on-surface/40 dark:text-on-surface-dark/40"
                                    />
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <h3
                                        class="truncate text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong"
                                    >
                                        {{ $post->title }}
                                    </h3>
                                    <x-badge
                                        :variant="$post->status === 'published' ? 'success' : 'default'"
                                        size="sm"
                                    >
                                        {{ ucfirst($post->status) }}
                                    </x-badge>
                                </div>
                                <p class="mt-0.5 text-xs text-on-surface dark:text-on-surface-dark">
                                    {{ $post->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        @if ($post->tags->isNotEmpty() || $post->categories->isNotEmpty())
                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach ($post->tags as $tag)
                                    <x-badge size="sm" variant="info">{{ $tag->name }}</x-badge>
                                @endforeach
                                @foreach ($post->categories as $category)
                                    <x-badge size="sm" variant="default">{{ $category->name }}</x-badge>
                                @endforeach
                            </div>
                        @endif

                        <div
                            class="mt-3 flex items-center gap-1 border-t border-outline pt-3 dark:border-outline-dark"
                        >
                            <a
                                href="{{ route('posts.edit', $post) }}"
                                class="inline-flex items-center gap-1.5 rounded-radius px-2.5 py-1.5 text-xs font-medium text-on-surface transition-colors hover:bg-surface-alt hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-surface-dark-alt dark:hover:text-on-surface-dark-strong"
                            >
                                <x-icons.pencil-square variant="outline" size="xs" />
                                {{ __('Edit') }}
                            </a>
                            <button
                                type="button"
                                wire:click="confirmDelete({{ $post->id }})"
                                class="inline-flex items-center gap-1.5 rounded-radius px-2.5 py-1.5 text-xs font-medium text-danger transition-colors hover:bg-danger/10"
                            >
                                <x-icons.trash variant="outline" size="xs" />
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </x-slot>
        </x-table>

        <div>
            {{ $posts->links() }}
        </div>
    @else
        <x-empty-state
            title="{{ __('No posts found') }}"
            description="{{ $search || $statusFilter || $tagFilter || $categoryFilter || $categoryFilter ? __('Try adjusting your search or filters.') : __('Create your first post to get started.') }}"
        >
            @unless ($search || $statusFilter || $tagFilter || $categoryFilter)
                <x-slot name="action">
                    <x-button href="{{ route('posts.create') }}">{{ __('Create Post') }}</x-button>
                </x-slot>
            @endunless
        </x-empty-state>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingPostId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Post') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this post? This action cannot be undone.') }}
            </p>
        </div>
        <div
            class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end"
        >
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deletePost">{{ __('Delete Post') }}</x-button>
        </div>
    </x-modal>
</div>
