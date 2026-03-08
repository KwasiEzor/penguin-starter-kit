@props([
    'src' => null,
    'alt' => '',
    'initials' => null,
    'size' => 'md',
    'status' => null, // online, offline, away, busy
    'border' => false,
])

@php
    $sizes = [
        'xs' => 'size-6 text-[10px]',
        'sm' => 'size-8 text-xs',
        'md' => 'size-10 text-sm',
        'lg' => 'size-12 text-base',
        'xl' => 'size-16 text-xl',
        '2xl' => 'size-24 text-3xl',
    ];

    $statusColors = [
        'online' => 'bg-success',
        'offline' => 'bg-on-surface/30',
        'away' => 'bg-warning',
        'busy' => 'bg-danger',
    ];

    $statusSizes = [
        'xs' => 'size-1.5',
        'sm' => 'size-2',
        'md' => 'size-2.5',
        'lg' => 'size-3',
        'xl' => 'size-4',
        '2xl' => 'size-6',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $statusColor = $statusColors[$status] ?? null;
    $statusSize = $statusSizes[$size] ?? $statusSizes['md'];
@endphp

<div class="relative inline-flex shrink-0">
    @if ($src)
        <img
            src="{{ $src }}"
            alt="{{ $alt }}"
            {{ $attributes->merge(['class' => "rounded-full object-cover {$sizeClass}" . ($border ? ' ring-2 ring-surface dark:ring-surface-dark' : '')]) }}
        />
    @else
        <span
            {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-full bg-primary/10 font-black text-primary dark:bg-primary/20 {$sizeClass}" . ($border ? ' ring-2 ring-surface dark:ring-surface-dark' : '')]) }}
        >
            {{ $initials ?? '?' }}
        </span>
    @endif

    @if ($statusColor)
        <span 
            class="absolute bottom-0 right-0 rounded-full ring-2 ring-surface dark:ring-surface-dark {{ $statusColor }} {{ $statusSize }}"
            title="{{ ucfirst($status) }}"
        ></span>
    @endif
</div>
