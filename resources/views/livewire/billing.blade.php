<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-typography.heading accent size="xl" level="1">{{ __('Billing') }}</x-typography.heading>
        <x-typography.subheading size="lg">
            {{ __('Manage your subscription and view order history') }}
        </x-typography.subheading>
    </div>

    <x-separator />

    <!-- Current Subscription -->
    <x-card>
        <x-slot name="header">
            <x-typography.heading accent>{{ __('Subscription') }}</x-typography.heading>
        </x-slot>

        @if ($subscription && $subscription->active())
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ __('Active Subscription') }}
                    </p>
                    <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">
                        {{ $subscription->onGracePeriod() ? __('Cancels at end of billing period') : __('Renews automatically') }}
                    </p>
                </div>
                <x-badge variant="success">{{ __('Active') }}</x-badge>
            </div>

            @if ($hasStripeId)
                <div class="mt-4">
                    <x-button variant="outline" wire:click="redirectToPortal">
                        {{ __('Manage Subscription') }}
                    </x-button>
                </div>
            @endif
        @else
            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                {{ __('You don\'t have an active subscription.') }}
            </p>
            <div class="mt-4">
                <x-button href="{{ route('pricing') }}">{{ __('View Plans') }}</x-button>
            </div>
        @endif
    </x-card>

    <!-- Order History -->
    <x-card>
        <x-slot name="header">
            <x-typography.heading accent>{{ __('Order History') }}</x-typography.heading>
        </x-slot>

        @if ($orders->count())
            <div class="overflow-x-auto -mx-4">
                <table class="w-full text-sm text-left">
                    <thead
                        class="text-xs font-medium uppercase tracking-wider text-on-surface dark:text-on-surface-dark"
                    >
                        <tr>
                            <th class="px-4 py-2">{{ __('Product') }}</th>
                            <th class="px-4 py-2">{{ __('Amount') }}</th>
                            <th class="px-4 py-2">{{ __('Status') }}</th>
                            <th class="px-4 py-2">{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                        @foreach ($orders as $order)
                            <tr>
                                <td
                                    class="px-4 py-2 font-medium text-on-surface-strong dark:text-on-surface-dark-strong"
                                >
                                    {{ $order->product?->name ?? __('N/A') }}
                                </td>
                                <td class="px-4 py-2">{{ $order->formattedAmount() }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $variant = match ($order->status) {
                                            'completed' => 'success',
                                            'pending' => 'warning',
                                            'failed' => 'danger',
                                            'refunded' => 'info',
                                            default => 'default',
                                        };
                                    @endphp

                                    <x-badge :variant="$variant" size="sm">{{ ucfirst($order->status) }}</x-badge>
                                </td>
                                <td class="px-4 py-2 text-on-surface dark:text-on-surface-dark">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ __('No orders yet.') }}</p>
        @endif
    </x-card>
</div>
