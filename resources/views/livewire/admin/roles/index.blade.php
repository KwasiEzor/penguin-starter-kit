<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Roles') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Role Management') }}
            </p>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Define and control access levels for your application.') }}
            </p>
        </div>
        <x-button href="{{ route('admin.roles.create') }}" class="shadow-lg shadow-primary/20">
            <x-icons.plus variant="outline" size="sm" class="mr-1" />
            {{ __('New Role') }}
        </x-button>
    </div>

    <!-- Main Card -->
    <x-card padding="false">
        @if ($roles->count())
            <x-table>
                <x-slot name="head">
                    <x-table-heading>{{ __('Role Name') }}</x-table-heading>
                    <x-table-heading>{{ __('Assigned Users') }}</x-table-heading>
                    <x-table-heading>{{ __('Permission Count') }}</x-table-heading>
                    <x-table-heading class="text-right">{{ __('Actions') }}</x-table-heading>
                </x-slot>

                @foreach ($roles as $role)
                    <tr class="group hover:bg-surface-alt/30 dark:hover:bg-surface-dark/30 transition-colors" wire:key="role-{{ $role->id }}">
                        <x-table-cell>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                    {{ ucfirst($role->name) }}
                                </span>
                                @if ($role->name === 'admin')
                                    <x-badge variant="primary" size="sm">{{ __('System') }}</x-badge>
                                @endif
                            </div>
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center gap-2">
                                <x-icons.users variant="outline" size="xs" class="text-on-surface/40" />
                                <span class="text-sm font-semibold text-on-surface/70">{{ number_format($role->users_count) }}</span>
                            </div>
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center gap-2">
                                <x-icons.shield variant="outline" size="xs" class="text-on-surface/40" />
                                <span class="text-sm font-semibold text-on-surface/70">{{ number_format($role->permissions_count) }}</span>
                            </div>
                        </x-table-cell>
                        <x-table-cell>
                            <div class="flex items-center justify-end gap-1">
                                <a
                                    href="{{ route('admin.roles.edit', $role) }}"
                                    class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-primary/10 hover:text-primary dark:hover:bg-primary-dark/10 dark:hover:text-primary-dark"
                                    title="{{ __('Edit Role') }}"
                                >
                                    <x-icons.pencil-square variant="outline" size="sm" />
                                </a>
                                @if ($role->name !== 'admin' && $role->users_count === 0)
                                    <button
                                        type="button"
                                        wire:click="confirmDelete({{ $role->id }})"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface/60 transition-all hover:bg-danger/10 hover:text-danger"
                                        title="{{ __('Delete Role') }}"
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
                    <x-icons.shield variant="outline" size="xl" class="text-on-surface/20" />
                </div>
                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ __('No roles found') }}
                </h3>
                <p class="text-on-surface/60 max-w-xs text-center mt-1">
                    {{ __('Create your first role to start managing permissions.') }}
                </p>
                <x-button href="{{ route('admin.roles.create') }}" class="mt-6 shadow-lg shadow-primary/20">
                    {{ __('Create Role') }}
                </x-button>
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
                        {{ __('Delete Role') }}
                    </h3>
                    <p class="text-sm text-on-surface/60">{{ __('This action cannot be undone.') }}</p>
                </div>
            </div>
            
            <p class="text-on-surface dark:text-on-surface-dark mb-8 leading-relaxed">
                {{ __('Are you sure you want to delete this role? This will remove all associated permissions.') }}
            </p>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
                <x-button variant="danger" type="button" wire:click="deleteRole">{{ __('Delete Role') }}</x-button>
            </div>
        </div>
    </x-modal>
</div>
