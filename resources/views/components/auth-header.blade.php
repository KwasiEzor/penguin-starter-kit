@props([
    'title',
    'description',
])

<div class="flex w-full flex-col gap-2 text-center">
    <h1 class="text-xl font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $title }}</h1>
    <p class="text-center text-sm text-on-surface dark:text-on-surface-dark">{{ $description }}</p>
</div>
