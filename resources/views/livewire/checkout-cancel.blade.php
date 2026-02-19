<div class="flex flex-col items-center justify-center gap-6 py-12">
    <div class="rounded-full bg-warning/10 p-4">
        <svg
            class="size-12 text-warning"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
            />
        </svg>
    </div>

    <div class="text-center">
        <x-typography.heading accent size="xl" level="1">{{ __('Payment Cancelled') }}</x-typography.heading>
        <p class="mt-2 text-sm text-on-surface dark:text-on-surface-dark">
            {{ __('Your payment was cancelled. No charges were made.') }}
        </p>
    </div>

    <div class="flex gap-3">
        <x-button href="{{ route('pricing') }}">{{ __('Back to Pricing') }}</x-button>
        <x-button variant="outline" href="{{ route('dashboard') }}">{{ __('Go to Dashboard') }}</x-button>
    </div>
</div>
