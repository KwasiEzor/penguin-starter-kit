@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'px-2 py-0.5 text-[10px] tracking-wider uppercase font-bold',
        'md' => 'px-2.5 py-1 text-xs font-semibold',
        'lg' => 'px-3 py-1.5 text-sm font-semibold',
    ];

    $variants = [
        'default' => 'bg-surface-alt/50 text-on-surface border border-outline dark:bg-surface-dark/50 dark:text-on-surface-dark dark:border-outline-dark',
        'primary' => 'bg-primary/10 text-primary border border-primary/20 dark:bg-primary-dark/15 dark:text-primary-dark dark:border-primary-dark/20',
        'info' => 'bg-info/10 text-info border border-info/20',
        'success' => 'bg-success/10 text-success border border-success/20',
        'warning' => 'bg-warning/10 text-warning border border-warning/20',
        'danger' => 'bg-danger/10 text-danger border border-danger/20',
    ];

    $classes = 'inline-flex items-center rounded-full ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
