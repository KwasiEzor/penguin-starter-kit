<div class="flex flex-col gap-6">
    <x-auth-header title="Log in to your account" description="Enter your email and password below to log in" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                wire:model="form.email"
                placeholder="email@example.com"
                required
                autofocus
                autocomplete="email"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <x-link class="text-sm" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </x-link>
                @endif
            </div>

            <x-input
                variant="password"
                id="password"
                class="block mt-1 w-full"
                wire:model="form.password"
                placeholder="Password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <x-checkbox id="remember" wire:model="form.remember">
            <span>{{ __('Remember me') }}</span>
        </x-checkbox>

        <div class="flex items-center justify-end">
            <x-button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</x-button>
        </div>

        <div class="space-x-1 text-center text-sm text-on-surface dark:text-on-surface-dark">
            {{ __("Don't have an account?") }}
            <x-link href="{{ route('register') }}" wire:navigate>{{ __('Sign up') }}</x-link>
        </div>
    </form>
</div>
