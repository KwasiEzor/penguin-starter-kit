@props([
    'disabled' => false,
    'variant' => 'text',
    'viewable' => true,
])

@if ($variant === 'password')
    <div x-data="{ showPassword: false }" class="relative">
        <input
            x-bind:type="showPassword ? 'text' : 'password'"
            @disabled($disabled)
            {{ $attributes->merge(['class' => 'w-full rounded-radius border border-outline bg-surface autofill:bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:autofill:bg-surface/10 dark:focus-visible:outline-primary-dark']) }}
        />

        @if ($viewable)
            <button
                type="button"
                x-on:click="showPassword = !showPassword"
                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface dark:text-on-surface-dark"
                aria-label="Show password"
            >
                <x-icons.eye x-cloak x-show="!showPassword" variant="outline" size="md" />
                <x-icons.eye-slash x-cloak x-show="showPassword" variant="outline" size="md" />
            </button>
        @endif
    </div>
@else
    <input
        @disabled($disabled)
        {{ $attributes->merge(['class' => 'w-full rounded-radius border border-outline bg-surface autofill:bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:autofill:bg-surface/10 dark:focus-visible:outline-primary-dark']) }}
    />
@endif
