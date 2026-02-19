@props([
    'variant' => 'info',
    'dismissible' => false,
])

@php
    $variants = [
        'info' => 'border-info/20 bg-info/10 text-info',
        'success' => 'border-success/20 bg-success/10 text-success',
        'warning' => 'border-warning/20 bg-warning/10 text-warning',
        'danger' => 'border-danger/20 bg-danger/10 text-danger',
    ];

    $icons = [
        'info' => '<path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />',
        'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />',
        'danger' => '<path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
    ];

    $variantClass = $variants[$variant] ?? $variants['info'];
@endphp

<div
    {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-radius border p-4 {$variantClass}"]) }}
    @if ($dismissible) x-data="{ visible: true }" x-show="visible" x-transition @endif
    role="alert"
>
    <svg
        class="size-5 shrink-0 mt-0.5"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
    >
        {!! $icons[$variant] ?? $icons['info'] !!}
    </svg>
    <div class="flex-1 text-sm">
        {{ $slot }}
    </div>
    @if ($dismissible)
        <button x-on:click="visible = false" class="shrink-0 opacity-70 hover:opacity-100" aria-label="Dismiss">
            <svg
                class="size-4"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
