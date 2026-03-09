@props([
    'active' => null, // ID of the initially active item
    'multiple' => false, // Allow multiple items to be open at once
])

<div
    x-data="accordion({{ json_encode($active) }}, {{ json_encode($multiple) }})"
    {{ $attributes->merge(['class' => 'space-y-2']) }}
>
    {{ $slot }}
</div>
