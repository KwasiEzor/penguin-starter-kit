<div>
    <div class="mb-4">
        <x-typography.heading accent>{{ __('Transactions') }}</x-typography.heading>
    </div>

    @if ($orders->count())
        <x-table>
            <x-slot name="head">
                <x-table-heading>{{ __('User') }}</x-table-heading>
                <x-table-heading>{{ __('Product') }}</x-table-heading>
                <x-table-heading>{{ __('Amount') }}</x-table-heading>
                <x-table-heading>{{ __('Status') }}</x-table-heading>
                <x-table-heading>{{ __('Date') }}</x-table-heading>
            </x-slot>

            @foreach ($orders as $order)
                <tr wire:key="order-{{ $order->id }}">
                    <x-table-cell class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $order->user?->name ?? __('Deleted User') }}
                    </x-table-cell>
                    <x-table-cell>{{ $order->product?->name ?? '-' }}</x-table-cell>
                    <x-table-cell>{{ $order->formattedAmount() }}</x-table-cell>
                    <x-table-cell>
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
                    </x-table-cell>
                    <x-table-cell>{{ $order->created_at->format('M d, Y H:i') }}</x-table-cell>
                </tr>
            @endforeach
        </x-table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <x-empty-state
            title="{{ __('No transactions yet') }}"
            description="{{ __('Transactions will appear here when customers make purchases.') }}"
        />
    @endif
</div>
