<div class="flex flex-col items-center justify-center gap-6 py-12">
    <div class="rounded-full bg-success/10 p-4">
        <svg class="size-12 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </div>

    <div class="text-center">
        <x-typography.heading accent size="xl" level="1">{{ __('Payment Successful!') }}</x-typography.heading>
        <p class="mt-2 text-sm text-on-surface dark:text-on-surface-dark">{{ __('Thank you for your purchase. Your payment has been processed successfully.') }}</p>
    </div>

    <div class="flex gap-3">
        <x-button href="{{ route('billing') }}">{{ __('View Billing') }}</x-button>
        <x-button variant="outline" href="{{ route('dashboard') }}">{{ __('Go to Dashboard') }}</x-button>
    </div>
</div>
