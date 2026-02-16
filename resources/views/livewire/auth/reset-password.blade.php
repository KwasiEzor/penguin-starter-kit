<div class="flex flex-col gap-6">
    <x-auth-header title="Reset password" description="Please enter your new password below" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email"
                wire:model="email"
                placeholder="email@example.com" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-input variant="password" id="password" class="block mt-1 w-full"
                wire:model="password"
                placeholder="Password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-input variant="password" id="password_confirmation" class="block mt-1 w-full"
                wire:model="password_confirmation"
                placeholder="Confirm Password" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Reset Password') }}</x-button>
        </div>
    </form>
</div>
