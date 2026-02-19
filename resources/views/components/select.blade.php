@props([
    'disabled' => false,
])

<select
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full rounded-radius border border-outline bg-surface px-2 py-2 text-sm text-on-surface focus:border-outline focus:ring-0 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:text-on-surface-dark dark:bg-surface/10 dark:focus-visible:outline-primary-dark appearance-none bg-no-repeat bg-[length:16px] bg-[right_8px_center] bg-[url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 20\' fill=\'currentColor\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z\' clip-rule=\'evenodd\'/%3E%3C/svg%3E")]']) }}
>
    {{ $slot }}
</select>
