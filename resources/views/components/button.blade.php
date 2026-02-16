@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    $baseClasses = 'cursor-pointer flex items-center justify-center gap-2 rounded-radius text-center tracking-wide hover:opacity-75 focus-visible:outline focus-visible:outline-2
focus-visible:outline-offset-2 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed';

    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-2.5 text-base',
    ];

    $variants = [
        'primary' => 'border bg-primary border-primary text-on-primary font-bold focus-visible:outline-primary dark:bg-primary-dark dark:text-on-primary-dark dark:border-primary-dark dark:focus-visible:outline-primary-dark',
        'secondary' => 'whitespace-nowrap border border-secondary bg-secondary text-on-secondary font-bold focus-visible:outline-primary disabled:opacity-75 disabled:cursor-not-allowed dark:border-secondary-dark dark:bg-secondary-dark dark:text-on-secondary-dark dark:focus-visible:outline-primary-dark',
        'outline' => 'whitespace-nowrap border border-on-surface bg-transparent text-on-surface font-medium focus-visible:outline-on-surface disabled:opacity-75 disabled:cursor-not-allowed dark:border-on-surface-dark dark:text-on-surface-dark dark:focus-visible:outline-on-surface-dark',
        'ghost' => 'whitespace-nowrap bg-transparent text-on-surface font-medium focus-visible:outline-on-surface disabled:opacity-75 disabled:cursor-not-allowed dark:text-on-surface-dark dark:focus-visible:outline-on-surface-dark',
        'info' => 'border bg-info border-info text-on-info font-bold focus-visible:outline-info',
        'danger' => 'border bg-danger border-danger text-on-danger font-bold focus-visible:outline-danger',
        'success' => 'border bg-success border-success text-on-success font-bold focus-visible:outline-success',
        'warning' => 'border bg-warning border-warning text-on-warning font-bold focus-visible:outline-warning',
    ];

    $classes =
        $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
