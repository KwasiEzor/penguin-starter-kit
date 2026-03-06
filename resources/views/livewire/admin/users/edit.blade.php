<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-on-surface/40 mb-2">
            <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors">{{ __('Users') }}</a>
            <x-icons.chevron-right size="xs" />
            <span class="text-on-surface/60">{{ __('Edit Profile') }}</span>
        </div>
        <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('Edit User') }}: <span class="text-primary">{{ $user->name }}</span>
        </h1>
    </div>

    <!-- Form Area -->
    <form wire:submit="save" class="grid gap-8 lg:grid-cols-3">
        <!-- Sidebar: Avatar & Actions -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <x-card>
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Profile Picture') }}</span>
                </x-slot>
                
                <div class="flex flex-col items-center py-4">
                    <div class="relative group">
                        @if ($avatar && method_exists($avatar, 'isPreviewable') && $avatar->isPreviewable())
                            <img src="{{ $avatar->temporaryUrl() }}" class="size-32 rounded-3xl object-cover ring-4 ring-primary/10" />
                        @elseif ($user->avatarUrl())
                            <img src="{{ $user->avatarUrl() }}" class="size-32 rounded-3xl object-cover ring-4 ring-primary/10" />
                        @else
                            <div class="size-32 rounded-3xl bg-surface-alt dark:bg-surface-dark flex items-center justify-center text-3xl font-black text-on-surface/20 ring-4 ring-primary/10">
                                {{ $user->initials() }}
                            </div>
                        @endif
                        
                        <div class="mt-6 w-full">
                            <x-file-upload wire:model="avatar" :label="$user->avatarUrl() ? __('Change Photo') : __('Upload Photo')" />
                        </div>
                        
                        @if ($user->avatarUrl() && ! $avatar)
                            <button
                                type="button"
                                wire:click="removeAvatar"
                                class="mt-2 w-full text-xs font-bold text-danger hover:underline"
                            >
                                {{ __('Remove current photo') }}
                            </button>
                        @endif
                    </div>
                    
                    <x-input-error :messages="$errors->get('avatar')" class="mt-4" />
                    <div wire:loading wire:target="avatar" class="mt-4 flex items-center gap-2 text-xs font-bold text-primary animate-pulse">
                        <x-icons.arrow-path class="size-3 animate-spin" />
                        {{ __('UPLOADING...') }}
                    </div>
                </div>
            </x-card>

            <div class="flex flex-col gap-3">
                <x-button type="submit" class="w-full shadow-lg shadow-primary/20">
                    {{ __('Save Profile') }}
                </x-button>
                <x-button variant="ghost" href="{{ route('admin.users.index') }}" class="w-full">
                    {{ __('Back to Users') }}
                </x-button>
            </div>
        </div>

        <!-- Main Form Fields -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <x-card padding="false">
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Account Information') }}</span>
                </x-slot>

                <div class="p-8 space-y-8">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <x-input-label for="name" value="{{ __('Full Name') }}" />
                            <x-input id="name" wire:model="name" placeholder="John Doe" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <x-input-label for="email" value="{{ __('Email Address') }}" />
                            <x-input id="email" type="email" wire:model="email" placeholder="john@example.com" />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-input-label for="role" value="{{ __('Access Level') }}" />
                        @if ($isSelf)
                            <div class="flex items-center gap-2 px-4 py-2.5 rounded-radius bg-surface-alt/50 border border-outline dark:bg-surface-dark/50 dark:border-outline-dark">
                                <x-icons.shield size="xs" class="text-primary" />
                                <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ ucfirst($role) }}</span>
                                <span class="text-[10px] uppercase font-black text-on-surface/30 ml-auto tracking-widest">{{ __('Locked') }}</span>
                            </div>
                            <p class="text-[11px] text-on-surface/50 italic">{{ __('You cannot demote your own administrative access.') }}</p>
                        @else
                            <x-select id="role" wire:model="role">
                                @foreach ($roles as $roleOption)
                                    <option value="{{ $roleOption->value }}">{{ $roleOption->label() }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error :messages="$errors->get('role')" />
                        @endif
                    </div>
                </div>
            </x-card>

            <x-card padding="false">
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Security Update') }}</span>
                </x-slot>

                <div class="p-8 space-y-8">
                    <p class="text-xs text-on-surface/60 bg-surface-alt/50 p-4 rounded-xl border border-outline dark:bg-surface-dark/50 dark:border-outline-dark">
                        {{ __('Only fill these fields if you wish to reset the user\'s password. Otherwise, leave them blank to keep the current credentials.') }}
                    </p>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <x-input-label for="password" value="{{ __('New Password') }}" />
                            <x-input id="password" type="password" wire:model="password" placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-input id="password_confirmation" type="password" wire:model="password_confirmation" placeholder="••••••••" />
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </form>
</div>
