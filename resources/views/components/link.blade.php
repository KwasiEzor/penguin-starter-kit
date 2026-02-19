<a
    {{ $attributes->merge(['class' => 'font-medium text-primary underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark']) }}
>
    {{ $slot }}
</a>
