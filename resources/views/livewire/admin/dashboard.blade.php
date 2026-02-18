<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-typography.heading accent size="xl" level="1">{{ __('Admin Dashboard') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Overview of your application') }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Stats Cards -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <x-stat-card :label="__('Total Users')" :value="$totalUsers" color="primary" :href="route('admin.users.index')">
            <x-slot:icon>
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card :label="__('Total Posts')" :value="$totalPosts" color="info">
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
    </div>

    <!-- Recent Activity -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Recent Users -->
        <x-card>
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <x-typography.heading accent>{{ __('Recent Users') }}</x-typography.heading>
                    <x-button size="xs" variant="ghost" href="{{ route('admin.users.index') }}">{{ __('View all') }}</x-button>
                </div>
            </x-slot>
            @forelse ($recentUsers as $user)
                <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b border-outline dark:border-outline-dark' : '' }}">
                    <x-avatar :src="$user->avatarUrl()" :initials="$user->initials()" size="sm" />
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong truncate">{{ $user->name }}</p>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark truncate">{{ $user->email }}</p>
                    </div>
                    @php $roleName = $user->roles->first()?->name ?? 'user'; @endphp
                    <x-badge :variant="$roleName === 'admin' ? 'primary' : ($roleName === 'editor' ? 'info' : 'default')" size="sm">{{ ucfirst($roleName) }}</x-badge>
                </div>
            @empty
                <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ __('No users yet.') }}</p>
            @endforelse
        </x-card>

        <!-- Recent Posts -->
        <x-card>
            <x-slot name="header">
                <x-typography.heading accent>{{ __('Recent Posts') }}</x-typography.heading>
            </x-slot>
            @forelse ($recentPosts as $post)
                <div class="flex items-center gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b border-outline dark:border-outline-dark' : '' }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong truncate">{{ $post->title }}</p>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ __('by') }} {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    <x-badge :variant="$post->status === 'published' ? 'success' : 'default'" size="sm">{{ ucfirst($post->status) }}</x-badge>
                </div>
            @empty
                <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ __('No posts yet.') }}</p>
            @endforelse
        </x-card>
    </div>
</div>
