<div class="flex flex-col gap-6">
    <x-auth-header
        title="Confirm password"
        description="This is a secure area of the application. Please confirm your password before continuing."
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-input
                variant="password"
                id="password"
                class="block mt-1 w-full"
                wire:model="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-button variant="primary" type="submit" class="w-full">
            {{ __('Confirm') }}
        </x-button>
    </form>
</div>
