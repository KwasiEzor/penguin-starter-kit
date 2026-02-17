@props([])

<td {{ $attributes->merge(['class' => 'px-4 py-3 text-on-surface dark:text-on-surface-dark']) }}>
    {{ $slot }}
</td>
