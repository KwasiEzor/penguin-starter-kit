@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center gap-4 px-4 py-2 rounded-radius bg-primary/10 font-medium text-sm pointer-events-none text-on-surface-strong underline-offset-2 focus:outline-hidden focus:underline dark:bg-primary-dark/10 dark:text-on-surface-dark-strong'
            : 'flex items-center gap-4 px-4 py-2 rounded-radius hover:bg-primary/5 font-medium text-sm text-on-surface underline-offset-2 hover:text-on-surface-strong focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
