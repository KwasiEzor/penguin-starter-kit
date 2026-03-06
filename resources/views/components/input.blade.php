@props([
    'disabled' => false,
    'variant' => 'text',
    'viewable' => true,
])

@php
    $inputClasses = 'w-full rounded-radius border border-outline bg-surface px-4 py-2.5 text-sm text-on-surface-strong transition-all duration-200 placeholder:text-on-surface/50 focus:border-primary/50 focus:ring-4 focus:ring-primary/5 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark-strong dark:placeholder:text-on-surface-dark/40 dark:focus:border-primary-dark/50 dark:focus:ring-primary-dark/5';
@endphp

@if ($variant === 'password')
    <div x-data="{ showPassword: false }" class="relative">
        <input
            x-bind:type="showPassword ? 'text' : 'password'"
            @disabled($disabled)
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        @if ($viewable)
            <button
                type="button"
                x-on:click="showPassword = !showPassword"
                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong transition-colors"
                aria-label="Show password"
            >
                <x-icons.eye x-cloak x-show="!showPassword" variant="outline" size="sm" />
                <x-icons.eye-slash x-cloak x-show="showPassword" variant="outline" size="sm" />
            </button>
        @endif
    </div>
@else
    <input
        @disabled($disabled)
        {{ $attributes->merge(['class' => $inputClasses]) }}
    />
@endif
