@props([
    'title' => 'No results found',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 text-center']) }}>
    @isset($icon)
        <div class="mb-4 text-on-surface/30 dark:text-on-surface-dark/30">
            {{ $icon }}
        </div>
    @else
        <div class="mb-4 text-on-surface/30 dark:text-on-surface-dark/30">
            <svg
                class="size-12"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                />
            </svg>
        </div>
    @endisset

    <h3 class="text-base font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $title }}</h3>

    @if ($description)
        <p class="mt-1 text-sm text-on-surface dark:text-on-surface-dark">{{ $description }}</p>
    @endif

    @isset($action)
        <div class="mt-4">
            {{ $action }}
        </div>
    @endisset
</div>
