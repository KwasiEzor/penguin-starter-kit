<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-typography.heading accent size="xl" level="1">{{ __('Dashboard') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Stats Cards -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat-card :label="__('My Posts')" :value="$totalPosts" color="primary" :href="route('posts.index')">
            <x-slot:icon>
                <x-icons.document-text class="size-6" />
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card :label="__('Published')" :value="$publishedPosts" color="success">
            <x-slot:icon>
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card :label="__('Drafts')" :value="$draftPosts" color="warning">
            <x-slot:icon>
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card :label="__('Notifications')" :value="$unreadNotifications" color="info">
            <x-slot:icon>
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Content Sections -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Recent Posts -->
        <div class="lg:col-span-2">
            <x-card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <x-typography.heading accent>{{ __('Recent Posts') }}</x-typography.heading>
                        <x-button size="xs" variant="ghost" href="{{ route('posts.create') }}">{{ __('New Post') }}</x-button>
                    </div>
                </x-slot>
                @forelse ($recentPosts as $post)
                    <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b border-outline dark:border-outline-dark' : '' }}">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('posts.edit', $post) }}" class="text-sm font-medium text-on-surface-strong hover:text-primary dark:text-on-surface-dark-strong dark:hover:text-primary-dark truncate block" wire:navigate>
                                {{ $post->title }}
                            </a>
                            <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <x-badge :variant="$post->status === 'published' ? 'success' : 'default'" size="sm">{{ ucfirst($post->status) }}</x-badge>
                    </div>
                @empty
                    <div class="py-6 text-center">
                        <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ __('No posts yet.') }}</p>
                        <x-button size="xs" class="mt-3" href="{{ route('posts.create') }}">{{ __('Create your first post') }}</x-button>
                    </div>
                @endforelse
                @if ($recentPosts->isNotEmpty())
                    <x-slot name="footer">
                        <a href="{{ route('posts.index') }}" class="text-xs font-medium text-primary hover:underline dark:text-primary-dark" wire:navigate>{{ __('View all posts') }} &rarr;</a>
                    </x-slot>
                @endif
            </x-card>
        </div>

        <!-- Quick Actions & Activity -->
        <div class="flex flex-col gap-6">
            <!-- Quick Actions -->
            <x-card>
                <x-slot name="header">
                    <x-typography.heading accent>{{ __('Quick Actions') }}</x-typography.heading>
                </x-slot>
                <div class="flex flex-col gap-2">
                    <x-button variant="ghost" href="{{ route('posts.create') }}" class="justify-start w-full">
                        <svg class="size-4 mr-2 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('New Post') }}
                    </x-button>
                    <x-button variant="ghost" href="{{ route('posts.index') }}" class="justify-start w-full">
                        <x-icons.document-text variant="outline" size="sm" class="mr-2 shrink-0" />
                        {{ __('Manage Posts') }}
                    </x-button>
                    <x-button variant="ghost" href="{{ route('settings') }}" class="justify-start w-full">
                        <x-icons.cog variant="outline" size="sm" class="mr-2 shrink-0" />
                        {{ __('Settings') }}
                    </x-button>
                </div>
            </x-card>

            <!-- Weekly Summary -->
            <x-card>
                <x-slot name="header">
                    <x-typography.heading accent>{{ __('This Week') }}</x-typography.heading>
                </x-slot>
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-primary/10 p-2 dark:bg-primary-dark/10">
                        <svg class="size-5 text-primary dark:text-primary-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $postsThisWeek }}</p>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ trans_choice('post created|posts created', $postsThisWeek) }}</p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
