@props([
    'href' => null,
    'active' => false,
])

<li class="flex items-center gap-1">
    @if (! $active && $href)
        <a
            href="{{ $href }}"
            {{ $attributes->merge(['class' => 'hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong transition-colors']) }}
        >
            {{ $slot }}
        </a>
    @else
        <span
            {{ $attributes->merge(['class' => $active ? 'font-medium text-on-surface-strong dark:text-on-surface-dark-strong' : '']) }}
        >
            {{ $slot }}
        </span>
    @endif
</li>

@if (! $active)
    <li aria-hidden="true" class="text-on-surface/50 dark:text-on-surface-dark/50">
        <x-icons.chevron-right size="xs" />
    </li>
@endif
