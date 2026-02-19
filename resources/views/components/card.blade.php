@props([
    'padding' => true,
])

<div
    {{ $attributes->merge(['class' => 'rounded-radius border border-outline bg-surface dark:border-outline-dark dark:bg-surface-dark-alt']) }}
>
    @isset($header)
        <div class="border-b border-outline px-4 py-3 dark:border-outline-dark">
            {{ $header }}
        </div>
    @endisset

    <div @class(['px-4 py-4' => $padding])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-outline px-4 py-3 dark:border-outline-dark">
            {{ $footer }}
        </div>
    @endisset
</div>
