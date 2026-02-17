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
    </div>

    <!-- Table -->
    @if ($posts->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading :sortable="true" :direction="$sortBy === 'title' ? $sortDirection : null" wire:click="sortBy('title')">
                    {{ __('Title') }}
                </x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading :sortable="true" :direction="$sortBy === 'created_at' ? $sortDirection : null" wire:click="sortBy('created_at')">
                    {{ __('Created') }}
                </x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($posts as $post)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="post-{{ $post->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $post->title }}
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
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" href="{{ route('posts.edit', $post) }}">
                                {{ __('Edit') }}
                            </x-button>
                            <x-button size="xs" variant="ghost" wire:click="confirmDelete({{ $post->id }})" class="text-danger hover:text-danger">
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>

        <div>
            {{ $posts->links() }}
        </div>
    @else
        <x-empty-state
            title="{{ __('No posts found') }}"
            description="{{ $search || $statusFilter ? __('Try adjusting your search or filters.') : __('Create your first post to get started.') }}">
            @unless ($search || $statusFilter)
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
        <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deletePost">{{ __('Delete Post') }}</x-button>
        </div>
    </x-modal>
</div>
