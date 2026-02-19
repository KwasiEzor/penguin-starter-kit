@props([
    'disabled' => false,
    'id' => null,
])

<label
    class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark [&:has(input:disabled)]:opacity-75 [&:has(input:disabled)]:cursor-not-allowed"
    for="{{ $id }}"
>
    <div class="relative">
        <input
            id="{{ $id }}"
            {{ $disabled ? 'disabled' : '' }}
            {!!
                $attributes->merge([
                    'type' => 'checkbox',
                    'role' => 'switch',
                    'class' => 'peer sr-only',
                ])
            !!}
        />
        <div
            class="h-6 w-11 rounded-full border border-outline bg-surface-alt transition-colors peer-checked:border-primary peer-checked:bg-primary peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-primary peer-disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:peer-checked:border-primary-dark dark:peer-checked:bg-primary-dark dark:peer-focus-visible:outline-primary-dark"
        ></div>
        <div
            class="absolute left-0.5 top-0.5 size-5 rounded-full bg-on-surface-strong shadow-sm transition-transform peer-checked:translate-x-5 peer-checked:bg-on-primary dark:bg-on-surface-dark-strong dark:peer-checked:bg-on-primary-dark"
        ></div>
    </div>
    @if ($slot->isNotEmpty())
        <span>{{ $slot }}</span>
    @endif
</label>
