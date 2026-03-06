@props([
    'disabled' => false,
])

<textarea
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full rounded-radius border border-outline bg-surface px-4 py-2.5 text-sm text-on-surface-strong transition-all duration-200 placeholder:text-on-surface/50 focus:border-primary/50 focus:ring-4 focus:ring-primary/5 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark-strong dark:placeholder:text-on-surface-dark/40 dark:focus:border-primary-dark/50 dark:focus:ring-primary-dark/5']) }}
>{{ $slot }}</textarea>
