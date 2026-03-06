<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-2">
            <a href="{{ route('admin.roles.index') }}" class="hover:text-primary transition-colors">{{ __('Roles') }}</a>
            <x-icons.chevron-right size="xs" />
            <span class="text-on-surface/60">{{ __('Edit') }}</span>
        </div>
        <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Edit Role') }}: <span class="text-primary">{{ ucfirst($role->name) }}</span>
        </h1>
    </div>

    <!-- Form Area -->
    <form wire:submit="save" class="grid gap-8 lg:grid-cols-3">
        <!-- Basic Settings -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <x-card>
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Identification') }}</span>
                </x-slot>
                
                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="{{ __('Role Name') }}" />
                        @if ($isAdminRole)
                            <x-input id="name" value="{{ $name }}" class="mt-1 !bg-surface-alt/50" disabled />
                            <p class="mt-2 text-xs text-on-surface/50 italic">
                                {{ __('The system administrator role name is protected.') }}
                            </p>
                        @else
                            <x-input id="name" wire:model="name" class="mt-1" placeholder="e.g. Moderator" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @endif
                    </div>
                </div>
            </x-card>

            <div class="flex flex-col gap-3">
                <x-button type="submit" class="w-full shadow-lg shadow-primary/20">
                    {{ __('Save Changes') }}
                </x-button>
                <x-button variant="ghost" href="{{ route('admin.roles.index') }}" class="w-full">
                    {{ __('Back to List') }}
                </x-button>
            </div>
        </div>

        <!-- Permissions Grid -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <h3 class="text-xs font-bold uppercase tracking-widest text-on-surface/40 px-1">{{ __('Permission Matrix') }}</h3>
            
            <div class="grid gap-6">
                @foreach ($permissionsByGroup as $group => $permissions)
                    <x-card padding="false">
                        <x-slot name="header">
                            <div class="flex items-center gap-2">
                                <div class="size-2 rounded-full bg-primary/40"></div>
                                <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $group }}</span>
                            </div>
                        </x-slot>
                        
                        <div class="grid grid-cols-1 divide-y divide-outline dark:divide-outline-dark sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                            @foreach ($permissions as $permission)
                                <label class="group flex items-center gap-3 p-4 cursor-pointer hover:bg-surface-alt/30 transition-colors">
                                    <div class="relative flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model="selectedPermissions"
                                            value="{{ $permission->value }}"
                                            class="peer size-5 rounded-lg border-outline-strong text-primary focus:ring-4 focus:ring-primary/10 dark:border-outline-dark-strong dark:bg-surface-dark dark:text-primary-dark"
                                        />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong group-hover:text-primary transition-colors">
                                            {{ $permission->label() }}
                                        </span>
                                        <span class="text-[10px] text-on-surface/40 font-mono">{{ $permission->value }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>
    </form>
</div>
