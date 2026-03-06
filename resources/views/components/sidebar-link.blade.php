@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'flex items-center gap-3 px-3 py-2 rounded-radius bg-primary/10 font-semibold text-sm text-primary transition-all duration-200 dark:bg-primary-dark/15 dark:text-primary-dark'
            : 'flex items-center gap-3 px-3 py-2 rounded-radius hover:bg-primary/5 font-medium text-sm text-on-surface hover:text-on-surface-strong transition-all duration-200 dark:text-on-surface-dark dark:hover:bg-primary-dark/10 dark:hover:text-on-surface-dark-strong';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
