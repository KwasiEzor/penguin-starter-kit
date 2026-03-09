<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Profile Information Section -->
    <x-card class="overflow-hidden border-none shadow-premium-lg ring-1 ring-outline/5 dark:ring-outline-dark/5">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 dark:bg-primary-dark/10 rounded-radius text-primary dark:text-primary-dark">
                    <x-icons.pencil-square class="size-5" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="font-bold">
                        {{ __('Profile Information') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm">
                        {{ __('Update your account\'s profile information and email address.') }}
                    </x-typography.subheading>
                </div>
            </div>
        </x-slot>

        <div class="space-y-8">
            <!-- Avatar Upload -->
            <div class="group relative">
                <x-input-label :value="__('Avatar')" class="mb-4 text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative group/avatar">
                        @php
                            $avatarUrl = auth()->user()->avatarUrl();
                        @endphp
                        
                        <div class="relative overflow-hidden rounded-full ring-4 ring-surface-alt/50 dark:ring-surface-dark/50 transition-all duration-300 group-hover/avatar:ring-primary/20 dark:group-hover/avatar:ring-primary-dark/20">
                            <x-avatar :src="$avatarUrl" :initials="auth()->user()->initials()" size="xl" class="size-24 scale-100 transition-transform duration-500 group-hover/avatar:scale-110" />
                            
                            <!-- Hover Overlay -->
                            <label class="absolute inset-0 flex cursor-pointer items-center justify-center bg-surface-strong/40 opacity-0 transition-opacity duration-300 group-hover/avatar:opacity-100 backdrop-blur-[2px]">
                                <x-icons.arrow-path class="size-6 text-white animate-spin-slow" wire:loading wire:target="avatar" />
                                <div wire:loading.remove wire:target="avatar" class="flex flex-col items-center text-white">
                                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="file" wire:model="avatar" accept="image/*" class="sr-only" />
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 items-center sm:items-start">
                        <div class="flex gap-2">
                            <label class="inline-flex cursor-pointer items-center gap-2 rounded-radius bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-primary/90 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/20">
                                {{ __('Upload New Photo') }}
                                <input type="file" wire:model="avatar" accept="image/*" class="sr-only" />
                            </label>
                            
                            @if ($avatarUrl)
                                <button type="button" wire:click="removeAvatar" class="inline-flex items-center gap-2 rounded-radius border border-outline px-4 py-2 text-sm font-semibold text-danger transition-colors hover:bg-danger/5 dark:border-outline-dark">
                                    {{ __('Remove') }}
                                </button>
                            @endif
                        </div>
                        <p class="text-xs text-on-surface/60 dark:text-on-surface-dark/60">
                            {{ __('Allowed formats: PNG, JPG, GIF. Max size 1MB.') }}
                        </p>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            </div>

            <x-separator class="opacity-50" />

            <!-- Profile Form -->
            <form wire:submit="updateProfile" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Full Name')" class="text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                        <div class="relative group">
                            <x-input
                                id="name"
                                type="text"
                                class="w-full pl-3 transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30"
                                wire:model="name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" class="text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                        <div class="relative group">
                            <x-input
                                id="email"
                                type="email"
                                class="w-full pl-3 transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30"
                                wire:model="email"
                                required
                                autocomplete="email"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" />

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div class="mt-2 p-3 bg-warning/10 rounded-radius flex items-start gap-3 border border-warning/20">
                                <div class="text-warning mt-0.5">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                </div>
                                <p class="text-xs text-warning-strong font-medium">
                                    {{ __('Your email address is unverified.') }}
                                    <button
                                        type="button"
                                        wire:click="$dispatch('send-verification')"
                                        class="underline hover:no-underline focus:outline-none"
                                    >
                                        {{ __('Resend verification email') }}
                                    </button>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4">
                    <x-button variant="primary" type="submit" class="px-8 shadow-lg shadow-primary/20">
                        {{ __('Save Changes') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-card>

    <!-- Danger Zone -->
    <x-card class="border-danger/10 bg-danger/5 dark:border-danger/20 dark:bg-danger/5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-danger/10 rounded-radius text-danger">
                    <x-icons.trash class="size-6" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="text-danger dark:text-danger font-bold">
                        {{ __('Delete Account') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm" class="text-danger/70 dark:text-danger/70">
                        {{ __('Permanently delete your account and all of its data. This action cannot be undone.') }}
                    </x-typography.subheading>
                </div>
            </div>

            <x-modal name="confirm-user-deletion" :maxWidth="'lg'">
                <x-slot name="trigger">
                    <x-button variant="danger" x-on:click="modalIsOpen = true" class="shadow-lg shadow-danger/20">
                        {{ __('Delete Account') }}
                    </x-button>
                </x-slot>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-danger/10 rounded-full text-danger">
                            <x-icons.trash class="size-5" />
                        </div>
                        <x-typography.heading accent size="lg" class="font-bold">
                            {{ __('Confirm Deletion') }}
                        </x-typography.heading>
                    </div>
                </x-slot>
                
                <div class="p-6 space-y-6">
                    <p class="text-sm text-on-surface dark:text-on-surface-dark leading-relaxed">
                        {{ __('Are you absolutely sure? Once your account is deleted, all of its resources and data will be permanently removed. To confirm, please enter your password below.') }}
                    </p>
                    
                    <div class="space-y-2">
                        <x-input-label for="delete-password" value="{{ __('Confirm Password') }}" class="sr-only" />
                        <x-input
                            variant="password"
                            id="delete-password"
                            placeholder="{{ __('Enter your password') }}"
                            class="block w-full border-danger/20 focus:ring-danger/20"
                            type="password"
                            wire:model="deletePassword"
                            required
                        />
                        <x-input-error :messages="$errors->get('deletePassword')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-outline/10 bg-surface-alt/30 p-4 dark:border-outline-dark/10">
                    <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false" class="text-on-surface/60">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button variant="danger" type="button" wire:click="deleteAccount" class="shadow-lg shadow-danger/20">
                        {{ __('Permanently Delete') }}
                    </x-button>
                </div>
            </x-modal>
        </div>
    </x-card>
</div>
