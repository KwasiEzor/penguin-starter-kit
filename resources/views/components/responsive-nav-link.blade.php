@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'pointer-events-none w-full text-lg font-bold text-on-surface-strong focus:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary focus-visible:outline-offset-2 dark:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark'
            : 'flex items-center gap-2 w-full text-on-surface focus:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary focus-visible:outline-offset-2 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
