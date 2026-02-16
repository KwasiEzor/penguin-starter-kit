@props([
    'size' => null,
])

@php
    $sizeClasses = match ($size) {
        'xl' => 'text-lg',
        'lg' => 'text-base',
        'sm' => 'text-xs',
        default => 'text-sm',
    };

    $textClasses = 'text-on-surface dark:text-on-surface-dark';

    $classes = "{$sizeClasses} {$textClasses}";
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>
