@props([
    'name' => '',
])

<div x-cloak x-show="activeTab === '{{ $name }}'" role="tabpanel" {{ $attributes }}>
    {{ $slot }}
</div>
