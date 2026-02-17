@props([
    'src' => null,
    'alt' => '',
    'initials' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'xs' => 'size-6 text-xs',
        'sm' => 'size-8 text-xs',
        'md' => 'size-10 text-sm',
        'lg' => 'size-12 text-base',
        'xl' => 'size-16 text-lg',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => "inline-block rounded-full object-cover {$sizeClass}"]) }} />
@else
    <span {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-full bg-primary font-medium text-on-primary dark:bg-primary-dark dark:text-on-primary-dark {$sizeClass}"]) }}>
        {{ $initials ?? '?' }}
    </span>
@endif
