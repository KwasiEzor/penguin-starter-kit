@props([
    'size' => 'base',
    'accent' => false,
    'level' => null,
])

@php
    $baseClasses = 'font-medium';

    $accentClasses = match ($accent) {
        true => 'text-on-surface-strong dark:text-on-surface-dark-strong',
        default => 'text-on-surface dark:text-on-surface-dark',
    };

    $sizeClasses = match ($size) {
        'xl' => 'text-2xl',
        'lg' => 'text-base',
        'base' => 'text-sm',
    };

    $classes = "{$baseClasses} {$accentClasses} {$sizeClasses}";
@endphp

@switch($level)
    @case(1)
        <h1 {{ $attributes->class($classes) }}>{{ $slot }}</h1>
    @break

    @case(2)
        <h2 {{ $attributes->class($classes) }}>{{ $slot }}</h2>
    @break

    @case(3)
        <h3 {{ $attributes->class($classes) }}>{{ $slot }}</h3>
    @break

    @case(4)
        <h4 {{ $attributes->class($classes) }}>{{ $slot }}</h4>
    @break

    @default
        <div {{ $attributes->class($classes) }}>{{ $slot }}</div>
@endswitch
