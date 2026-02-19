<div class="flex flex-col gap-6">
    <x-auth-header
        title="Verify email"
        description="Please verify your email address by clicking on the link we just emailed to you."
    />

    @if (session('status') == 'verification-link-sent')
        <div class="font-medium text-center text-sm text-success">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-button variant="primary" type="button" wire:click="sendVerification" class="w-full">
            {{ __('Resend Verification Email') }}
        </x-button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-on-surface dark:text-on-surface-dark hover:underline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>
