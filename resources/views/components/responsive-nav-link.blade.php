@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'pointer-events-none w-full text-lg font-bold text-on-surface-strong focus:underline dark:text-on-surface-dark-strong'
            : 'flex items-center gap-2 w-full text-on-surface focus:underline dark:text-on-surface-dark';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
