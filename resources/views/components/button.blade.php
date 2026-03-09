@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-radius font-semibold transition-all duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:cursor-not-allowed active:scale-[0.98]';

    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3.5 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-7 py-3 text-base',
    ];

    $variants = [
        'primary' => 'bg-primary text-on-primary shadow-sm hover:bg-primary/90 hover:shadow-md dark:bg-primary-dark dark:text-on-primary-dark',
        'secondary' => 'bg-secondary text-on-secondary shadow-sm hover:bg-secondary/90 hover:shadow-md dark:bg-secondary-dark dark:text-on-secondary-dark',
        'outline' => 'bg-transparent border border-outline-strong text-on-surface-strong hover:bg-surface-alt dark:border-outline-dark-strong dark:text-on-surface-dark-strong dark:hover:bg-surface-dark/50',
        'ghost' => 'bg-transparent text-on-surface hover:bg-surface-alt dark:text-on-surface-dark dark:hover:bg-surface-dark/50',
        'info' => 'bg-info text-on-info hover:opacity-90 shadow-sm',
        'danger' => 'bg-danger text-on-danger hover:opacity-90 shadow-sm',
        'success' => 'bg-success text-on-success hover:opacity-90 shadow-sm',
        'warning' => 'bg-warning text-on-warning hover:opacity-90 shadow-sm',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }} wire:navigate>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
