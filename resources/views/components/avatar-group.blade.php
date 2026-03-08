@props([
    'limit' => null,
    'total' => null,
])

<div {{ $attributes->merge(['class' => 'flex items-center -space-x-3 overflow-hidden']) }}>
    {{ $slot }}

    @if ($limit && $total && $total > $limit)
        <div class="relative z-10 flex size-10 items-center justify-center rounded-full bg-surface-alt ring-2 ring-surface text-xs font-bold text-on-surface dark:bg-surface-dark dark:ring-surface-dark dark:text-on-surface-dark">
            +{{ $total - $limit }}
        </div>
    @endif
</div>
