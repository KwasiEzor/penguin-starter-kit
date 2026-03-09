<div class="animate-in fade-in duration-500">
    <x-card class="overflow-hidden border-none shadow-premium-lg ring-1 ring-outline/5 dark:ring-outline-dark/5">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 dark:bg-primary-dark/10 rounded-radius text-primary dark:text-primary-dark">
                    <x-icons.shield class="size-5" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="font-bold">
                        {{ __('Update Password') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </x-typography.subheading>
                </div>
            </div>
        </x-slot>

        <form wire:submit="updatePassword" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Current Password -->
                <div class="space-y-2">
                    <x-input-label for="current_password" :value="__('Current Password')" class="text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                    <x-input
                        variant="password"
                        id="current_password"
                        class="w-full transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30"
                        wire:model="current_password"
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('New Password')" class="text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                        <x-input
                            variant="password"
                            id="password"
                            class="w-full transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30"
                            wire:model="password"
                            autocomplete="new-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="text-xs font-semibold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60" />
                        <x-input
                            variant="password"
                            id="password_confirmation"
                            class="w-full transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30"
                            wire:model="password_confirmation"
                            autocomplete="new-password"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-outline/10 dark:border-outline-dark/10">
                <x-button variant="primary" type="submit" class="px-8 shadow-lg shadow-primary/20">
                    {{ __('Update Password') }}
                </x-button>
            </div>
        </form>
    </x-card>
</div>
