<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Users') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('User Management') }}
            </p>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('View, manage and assign roles to your platform users.') }}
            </p>
        </div>
        <x-button href="{{ route('admin.users.create') }}" class="shadow-lg shadow-primary/20">
            <x-icons.plus variant="outline" size="sm" class="mr-1" />
            {{ __('New User') }}
        </x-button>
    </div>

    <!-- Main Content Card -->
    <x-card padding="false">
        <x-slot name="header">
            <div class="flex flex-col gap-4 w-full md:flex-row md:items-center md:justify-between">
                <div class="relative flex-1 max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icons.magnifying-glass variant="outline" size="sm" class="text-on-surface/40" />
                    </div>
                    <x-input 
                        type="search" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="{{ __('Search by name or email...') }}" 
                        class="pl-10 !bg-surface-alt/50 border-transparent focus:!bg-surface"
                    />
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold uppercase tracking-widest text-on-surface/40">{{ __('Filter by') }}</span>
                    <div class="w-40">
                        <x-select wire:model.live="roleFilter" class="!bg-surface-alt/50 border-transparent focus:!bg-surface">
                            <option value="">{{ __('All Roles') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}">{{ $role->label() }}</option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
            </div>
        </x-slot>

        @if ($users->count())
            <x-table>
                <x-slot name="head">
                    <x-table-heading class="w-16"></x-table-heading>
                    <x-table-heading
                        :sortable="true"
                        :direction="$sortBy === 'name' ? $sortDirection : null"
                        wire:click="sortBy('name')"
                    >
                        {{ __('User') }}
                    </x-table-heading>
                    <x-table-heading>{{ __('Role') }}</x-table-heading>
                    <x-table-heading
                        :sortable="true"
                        :direction="$sortBy === 'created_at' ? $sortDirection : null"
                        wire:click="sortBy('created_at')"
                    >
                        {{ __('Joined Date') }}
                    </x-table-heading>
                    <x-table-heading class="text-right">{{ __('Actions') }}</x-table-heading>
                </x-slot>

                @foreach ($users as $user)
                    <tr class="group hover:bg-surface-alt/30 dark:hover:bg-surface-dark/30 transition-colors" wire:key="user-{{ $user->id }}">
                        <x-table-cell>
                            <x-avatar :src="$user->avatarUrl()" :initials="$user->initials()" size="md" class="ring-2 ring-outline dark:ring-outline-dark ring-offset-2 dark:ring-offset-surface-dark" />
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong leading-tight">
                                    {{ $user->name }}
                                </span>
                                <span class="text-xs text-on-surface/60">{{ $user->email }}</span>
                            </div>
                        </x-table-cell>
                        <x-table-cell>
                            @php
                                $roleName = $user->roles->first()?->name ?? 'user';
                            @endphp
                            <x-badge
                                :variant="$roleName === 'admin' ? 'primary' : ($roleName === 'editor' ? 'info' : 'default')"
                                size="sm"
                            >
                                {{ ucfirst($roleName) }}
                            </x-badge>
                        </x-table-cell>
                        <x-table-cell class="text-on-surface/70">
                            {{ $user->created_at->format('M d, Y') }}
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center justify-end gap-1">
                                <a
                                    href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-primary/10 hover:text-primary dark:hover:bg-primary-dark/10 dark:hover:text-primary-dark"
                                    title="{{ __('Edit User') }}"
                                >
                                    <x-icons.pencil-square variant="outline" size="sm" />
                                </a>
                                @if ($user->id !== auth()->id())
                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $user->id }})"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-danger/10 hover:text-danger"
                                        title="{{ __('Delete User') }}"
                                    >
                                        <x-icons.trash variant="outline" size="sm" />
                                    </button>
                                @endif
                            </div>
                        </x-table-cell>
                    </tr>
                @endforeach
            </x-table>

            <div class="px-6 py-4 border-t border-outline dark:border-outline-dark">
                {{ $users->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20">
                <div class="bg-surface-alt dark:bg-surface-dark rounded-full p-6 mb-4">
                    <x-icons.users variant="outline" size="xl" class="text-on-surface/20" />
                </div>
                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('No users found') }}
                </h3>
                <p class="text-on-surface/60 max-w-xs text-center mt-1">
                    {{ $search || $roleFilter ? __('Try adjusting your search or filters.') : __('Create your first user to get started.') }}
                </p>
                @unless ($search || $roleFilter)
                    <x-button href="{{ route('admin.users.create') }}" class="mt-6 shadow-lg shadow-primary/20">
                        {{ __('Create User') }}
                    </x-button>
                @endunless
            </div>
        @endif
    </x-card>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" maxWidth="md">
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="flex size-12 items-center justify-center rounded-full bg-danger/10 text-danger">
                    <x-icons.trash variant="outline" size="md" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Delete User') }}
                    </h3>
                    <p class="text-sm text-on-surface/60">{{ __('This action cannot be undone.') }}</p>
                </div>
            </div>
            
            <p class="text-on-surface dark:text-on-surface-dark mb-8 leading-relaxed">
                {{ __('Are you sure you want to delete this user? All of their data will be permanently removed from our servers.') }}
            </p>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
                <x-button variant="danger" type="button" wire:click="deleteUser">{{ __('Delete User') }}</x-button>
            </div>
        </div>
    </x-modal>
</div>
