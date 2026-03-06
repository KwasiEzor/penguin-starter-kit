@props([
    'padding' => true,
])

<div
    {{ $attributes->merge(['class' => 'rounded-radius border border-outline bg-surface shadow-premium transition-all duration-200 dark:border-outline-dark dark:bg-surface-dark-alt']) }}
>
    @isset($header)
        <div class="border-b border-outline px-6 py-4 dark:border-outline-dark">
            <div class="flex items-center justify-between">
                {{ $header }}
            </div>
        </div>
    @endisset

    <div @class(['px-6 py-5' => $padding])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-outline px-6 py-4 bg-surface-alt/50 dark:border-outline-dark dark:bg-surface-dark/20">
            {{ $footer }}
        </div>
    @endisset
</div>
