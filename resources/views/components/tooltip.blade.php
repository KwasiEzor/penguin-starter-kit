@props([
    'text' => '',
    'position' => 'top',
])

@php
    $positions = [
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
    ];

    $positionClass = $positions[$position] ?? $positions['top'];
@endphp

<div x-data="{ show: false }" class="relative inline-flex" {{ $attributes }}>
    <div
        x-on:mouseenter="show = true"
        x-on:mouseleave="show = false"
        x-on:focus="show = true"
        x-on:blur="show = false"
    >
        {{ $slot }}
    </div>
    <div
        x-cloak
        x-show="show"
        x-transition.opacity.duration.150ms
        class="absolute z-50 {{ $positionClass }} pointer-events-none whitespace-nowrap rounded-md bg-on-surface-strong px-2 py-1 text-xs text-surface shadow-lg dark:bg-on-surface-dark-strong dark:text-surface-dark"
        role="tooltip"
    >
        {{ $text }}
    </div>
</div>
