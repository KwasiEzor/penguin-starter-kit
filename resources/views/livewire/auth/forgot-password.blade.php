<div class="flex flex-col gap-6">
    <x-auth-header title="Forgot password" description="Enter your email to receive a password reset link" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email"
                wire:model="email"
                placeholder="email@example.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-button variant="primary" type="submit" class="w-full">{{ __('Email Password Reset Link') }}</x-button>

        <div class="space-x-1 text-center text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Or return to') }}
            <x-link href="{{ route('login') }}" wire:navigate>{{ __('login') }}</x-link>
        </div>
    </form>
</div>
