@props([
    'active' => null,
])

<div x-data="{ activeTab: '{{ $active }}' }" {{ $attributes }}>
    <!-- Tab Navigation -->
    <div class="flex gap-1 border-b border-outline dark:border-outline-dark" role="tablist">
        {{ $tabs }}
    </div>

    <!-- Tab Panels -->
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
