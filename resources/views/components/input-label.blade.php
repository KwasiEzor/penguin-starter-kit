@props([
    'value',
])

<label {{ $attributes->merge(['class' => 'text-sm font-medium text-on-surface dark:text-on-surface-dark']) }}>
    {{ $value ?? $slot }}
</label>
