@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'primary',
    'href' => null,
    'change' => null,
    'changeLabel' => null,
])

@php
    $colorClasses = match ($color) {
        'primary' => 'bg-primary/10 text-primary dark:bg-primary-dark/10 dark:text-primary-dark',
        'info' => 'bg-info/10 text-info',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'danger' => 'bg-danger/10 text-danger',
        default => 'bg-primary/10 text-primary dark:bg-primary-dark/10 dark:text-primary-dark',
    };
@endphp

<x-card>
    <div class="flex items-center justify-between">
        <div class="min-w-0">
            <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ $label }}</p>
            <p class="mt-1 text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $value }}</p>
            @if ($change !== null)
                <p class="mt-1 flex items-center gap-1 text-xs {{ $change >= 0 ? 'text-success' : 'text-danger' }}">
                    @if ($change >= 0)
                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                    @else
                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25" /></svg>
                    @endif
                    <span>{{ $change >= 0 ? '+' : '' }}{{ $change }}{{ $changeLabel ? " $changeLabel" : '' }}</span>
                </p>
            @endif
        </div>
        @if ($icon)
            <div class="rounded-full p-3 {{ $colorClasses }}">
                {{ $icon }}
            </div>
        @endif
    </div>
    @if ($href)
        <div class="mt-3 border-t border-outline pt-3 dark:border-outline-dark">
            <a href="{{ $href }}" class="text-xs font-medium text-primary hover:underline dark:text-primary-dark" wire:navigate>{{ __('View all') }} &rarr;</a>
        </div>
    @endif
</x-card>
