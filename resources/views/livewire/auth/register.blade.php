<div class="flex flex-col gap-6">
    <x-auth-header title="Create an account" description="Enter your details below to create your account" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-input id="name" class="block mt-1 w-full" type="text"
                wire:model="form.name"
                placeholder="Full name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email"
                wire:model="form.email"
                placeholder="email@example.com" required autocomplete="email" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-input variant="password" id="password" class="block mt-1 w-full"
                wire:model="form.password"
                placeholder="Password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-input variant="password" id="password_confirmation" class="block mt-1 w-full"
                wire:model="form.password_confirmation"
                placeholder="Confirm Password" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Create account') }}</x-button>
        </div>

        <div class="space-x-1 text-center text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Already have an account?') }}
            <x-link href="{{ route('login') }}" wire:navigate>{{ __('Log in') }}</x-link>
        </div>
    </form>
</div>
