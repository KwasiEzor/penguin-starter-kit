<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-breadcrumbs class="mb-4">
                <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
                <x-breadcrumb-item :active="true">{{ __('Roles') }}</x-breadcrumb-item>
            </x-breadcrumbs>

            <x-typography.heading accent size="xl" level="1">{{ __('Roles') }}</x-typography.heading>
            <x-typography.subheading size="lg">{{ __('Manage roles and permissions') }}</x-typography.subheading>
        </div>
        <x-button href="{{ route('admin.roles.create') }}">{{ __('Create Role') }}</x-button>
    </div>

    <x-separator />

    <!-- Table -->
    @if ($roles->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('Name') }}</x-table-heading>
                <x-table-heading>{{ __('Users') }}</x-table-heading>
                <x-table-heading>{{ __('Permissions') }}</x-table-heading>
                <x-table-heading>{{ __('Actions') }}</x-table-heading>
            </x-slot>

            @foreach ($roles as $role)
                <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50" wire:key="role-{{ $role->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ ucfirst($role->name) }}
                        @if ($role->name === 'admin')
                            <x-badge variant="primary" size="sm" class="ml-1">{{ __('System') }}</x-badge>
                        @endif
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge variant="default">{{ $role->users_count }}</x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <x-badge variant="default">{{ $role->permissions_count }}</x-badge>
                    </x-table-cell>
                    <x-table-cell>
                        <div class="flex items-center gap-2">
                            <x-button size="xs" variant="ghost" href="{{ route('admin.roles.edit', $role) }}">
                                {{ __('Edit') }}
                            </x-button>
                            @if ($role->name !== 'admin' && $role->users_count === 0)
                                <x-button
                                    size="xs"
                                    variant="ghost"
                                    wire:click="confirmDelete({{ $role->id }})"
                                    class="text-danger hover:text-danger"
                                >
                                    {{ __('Delete') }}
                                </x-button>
                            @endif
                        </div>
                    </x-table-cell>
                </tr>
            @endforeach
        </x-table>
    @else
        <x-empty-state
            title="{{ __('No roles found') }}"
            description="{{ __('Create your first role to get started.') }}"
        >
            <x-slot name="action">
                <x-button href="{{ route('admin.roles.create') }}">{{ __('Create Role') }}</x-button>
            </x-slot>
        </x-empty-state>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal :show="$deletingRoleId !== null" maxWidth="md">
        <x-slot name="trigger"><span></span></x-slot>
        <x-slot name="header">
            <x-typography.subheading accent size="lg">{{ __('Delete Role') }}</x-typography.subheading>
        </x-slot>
        <div class="p-4">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('Are you sure you want to delete this role? This action cannot be undone.') }}
            </p>
        </div>
        <div
            class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end"
        >
            <x-button variant="ghost" type="button" wire:click="cancelDelete">{{ __('Cancel') }}</x-button>
            <x-button variant="danger" type="button" wire:click="deleteRole">{{ __('Delete Role') }}</x-button>
        </div>
    </x-modal>
</div>
