<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-breadcrumbs class="mb-4">
                <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
                <x-breadcrumb-item :active="true">{{ __('Users') }}</x-breadcrumb-item>
            </x-breadcrumbs>

            <x-typography.heading accent size="xl" level="1">{{ __('Users') }}</x-typography.heading>
            <x-typography.subheading size="lg">{{ __('Manage user accounts') }}</x-typography.subheading>
        </div>
        <x-button href="{{ route('admin.users.create') }}">{{ __('Create User') }}</x-button>
    </div>

    <x-separator />

    <!-- Filters -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="flex-1">
            <x-input type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search users...') }}" />
        </div>
        <div class="w-full sm:w-40">
            <x-select wire:model.live="roleFilter">
                <option value="">{{ __('All Roles') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->value }}">{{ $role->label() }}</option>
                @endforeach
            </x-select>
        </div>
    </div>

    <!-- Table -->
    @if ($users->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Avatar') }}</x-table-heading>
                <x-table-heading :sortable="true" :direction="$sortBy === 'name' ? $sortDirection : null" wire:click="sortBy('name')">
                    {{ __('Name') }}
                </x-table-heading>
                <x-table-heading :sortable="true" :direction="$sortBy === 'email' ? $sortDirection : null" wire:click="sortBy('email')">
                    {{ __('Email') }}
                </x-table-heading>
                <x-table-heading>{{ __('Role') }}</x-table-heading>
                <x-table-heading :sortable="true" :direction="$sortBy === 'created_at' ? $sortDirection : null" wire:click="sortBy('created_at')">
                    {{ __('Created') }}
                </x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($users as $user)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="user-{{ $user->id }}">
                    <x-table-cell>
                        <x-avatar :src="$user->avatarUrl()" :initials="$user->initials()" size="sm" />
                    </x-table-cell>
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $user->name }}
                    </x-table-cell>
                    <x-table-cell>
                        {{ $user->email }}
                    </x-table-cell>
                    <x-table-cell>
                        @php $roleName = $user->roles->first()?->name ?? 'user'; @endphp
                        <x-badge :variant="$roleName === 'admin' ? 'primary' : ($roleName === 'editor' ? 'info' : 'default')">
                            {{ ucfirst($roleName) }}
                        </x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        {{ $user->created_at->format('M d, Y') }}
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" href="{{ route('admin.users.edit', $user) }}">
                                {{ __('Edit') }}
                            </x-button>
                            @if ($user->id !== auth()->id())
                                <x-button size="xs" variant="ghost" wire:click="confirmDelete({{ $user->id }})" class="text-danger hover:text-danger">
                                    {{ __('Delete') }}
                                </x-button>
                            @endif
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>

        <div>
            {{ $users->links() }}
        </div>
    @else
        <x-empty-state
            title="{{ __('No users found') }}"
            description="{{ $search || $roleFilter ? __('Try adjusting your search or filters.') : __('Create your first user to get started.') }}">
            @unless ($search || $roleFilter)
                <x-slot name="action">
                    <x-button href="{{ route('admin.users.create') }}">{{ __('Create User') }}</x-button>
                </x-slot>
            @endunless
        </x-empty-state>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingUserId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete User') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this user? This action cannot be undone.') }}
            </p>
        </div>
        <div class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deleteUser">{{ __('Delete User') }}</x-button>
        </div>
    </x-modal>
</div>
