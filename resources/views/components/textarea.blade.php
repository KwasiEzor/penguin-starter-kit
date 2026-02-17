@props([
    'disabled' => false,
])

<textarea @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full rounded-radius border border-outline bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:focus-visible:outline-primary-dark']) }}>{{ $slot }}</textarea>
