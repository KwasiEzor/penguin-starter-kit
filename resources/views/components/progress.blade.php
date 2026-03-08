@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'variant' => 'primary',
    'label' => null,
    'showValue' => false,
])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));

    $sizes = [
        'xs' => 'h-1',
        'sm' => 'h-1.5',
        'md' => 'h-2.5',
        'lg' => 'h-4',
        'xl' => 'h-6',
    ];

    $variants = [
        'primary' => 'bg-primary shadow-lg shadow-primary/20',
        'secondary' => 'bg-secondary',
        'success' => 'bg-success shadow-lg shadow-success/20',
        'warning' => 'bg-warning shadow-lg shadow-warning/20',
        'danger' => 'bg-danger shadow-lg shadow-danger/20',
        'info' => 'bg-info shadow-lg shadow-info/20',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if ($label || $showValue)
        <div class="mb-2 flex items-center justify-between">
            @if ($label)
                <span class="text-xs font-bold uppercase tracking-widest text-on-surface/50 dark:text-on-surface-dark/50">
                    {{ $label }}
                </span>
            @endif
            @if ($showValue)
                <span class="text-xs font-black text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ round($percentage) }}%
                </span>
            @endif
        </div>
    @endif

    <div class="overflow-hidden rounded-full bg-on-surface/5 dark:bg-on-surface-dark/5 {{ $sizeClass }}">
        <div 
            class="h-full rounded-full transition-all duration-500 ease-out {{ $variantClass }}"
            style="width: {{ $percentage }}%"
        ></div>
    </div>
</div>
