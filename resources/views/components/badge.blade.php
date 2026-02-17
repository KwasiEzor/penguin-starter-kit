@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'px-1.5 py-0.5 text-xs',
        'md' => 'px-2 py-0.5 text-xs',
        'lg' => 'px-2.5 py-1 text-sm',
    ];

    $variants = [
        'default' => 'border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark',
        'primary' => 'border border-primary/20 bg-primary/10 text-primary dark:border-primary-dark/20 dark:bg-primary-dark/10 dark:text-primary-dark',
        'info' => 'border border-info/20 bg-info/10 text-info',
        'success' => 'border border-success/20 bg-success/10 text-success',
        'warning' => 'border border-warning/20 bg-warning/10 text-warning',
        'danger' => 'border border-danger/20 bg-danger/10 text-danger',
    ];

    $classes = 'inline-flex items-center rounded-full font-medium whitespace-nowrap ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
