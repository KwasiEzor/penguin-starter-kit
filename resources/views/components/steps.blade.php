@props([
    'active' => 1,
])

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute left-0 top-0 h-full w-px bg-on-surface/5 dark:bg-on-surface-dark/5 ml-4 lg:ml-5"></div>
    <div class="flex flex-col gap-8">
        {{ $slot }}
    </div>
</div>
