@props([])

<nav aria-label="Breadcrumb" {{ $attributes }}>
    <ol class="flex items-center gap-1 text-sm text-on-surface dark:text-on-surface-dark">
        {{ $slot }}
    </ol>
</nav>
