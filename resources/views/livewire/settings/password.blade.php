<section>
    <header>
        <x-typography.heading class="mb-2" accent>{{ __('Update password') }}</x-typography.heading>
        <x-typography.subheading>
            {{ __('Ensure your account is using a long, random password to stay secure') }}
        </x-typography.subheading>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-input
                variant="password"
                id="current_password"
                class="mt-1 block w-full"
                wire:model="current_password"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-input
                variant="password"
                id="password"
                class="mt-1 block w-full"
                wire:model="password"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-input
                variant="password"
                id="password_confirmation"
                class="mt-1 block w-full"
                wire:model="password_confirmation"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button variant="primary">{{ __('Save') }}</x-button>
        </div>
    </form>
</section>
