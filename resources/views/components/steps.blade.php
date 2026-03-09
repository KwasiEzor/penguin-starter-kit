@props([
    'active' => 1,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-12']) }}>
    {{ $slot }}
</div>
