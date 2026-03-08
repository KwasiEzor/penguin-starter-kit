@props([
    'variant' => 'default', // default, circle, pulse, wave
    'size' => 'md',
])

@php
    $variants = [
        'default' => 'rounded-md',
        'circle' => 'rounded-full',
        'pulse' => 'animate-pulse rounded-md',
        'wave' => 'animate-pulse bg-gradient-to-r from-on-surface/5 via-on-surface/10 to-on-surface/5 dark:from-on-surface-dark/5 dark:via-on-surface-dark/10 dark:to-on-surface-dark/5 bg-[length:200%_100%] animate-wave rounded-md',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<div 
    {{ $attributes->merge(['class' => "bg-on-surface/5 dark:bg-on-surface-dark/5 {$variantClass}"]) }}
></div>
