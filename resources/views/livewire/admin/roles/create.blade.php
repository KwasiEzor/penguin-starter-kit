<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
            <x-breadcrumb-item href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Create') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Create Role') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Define a new role with permissions') }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Form -->
    <form wire:submit="save" class="max-w-2xl space-y-6">
        <div>
            <x-input-label for="name" value="{{ __('Role Name') }}" />
            <x-input id="name" wire:model="name" class="mt-1" placeholder="{{ __('e.g. moderator') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label value="{{ __('Permissions') }}" />
            <div class="mt-2 space-y-4">
                @foreach ($permissionsByGroup as $group => $permissions)
                    <x-card>
                        <x-slot name="header">
                            <x-typography.heading size="base" accent>{{ $group }}</x-typography.heading>
                        </x-slot>
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            @foreach ($permissions as $permission)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->value }}"
                                        class="rounded border-outline text-primary focus:ring-primary dark:border-outline-dark dark:bg-surface-dark dark:text-primary-dark dark:focus:ring-primary-dark" />
                                    <span class="text-sm text-on-surface-strong dark:text-on-surface-dark-strong">{{ $permission->label() }}</span>
                                </label>
                            @endforeach
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-3">
            <x-button type="submit">{{ __('Create Role') }}</x-button>
            <x-button variant="ghost" href="{{ route('admin.roles.index') }}">{{ __('Cancel') }}</x-button>
        </div>
    </form>
</div>
