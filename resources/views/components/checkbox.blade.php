@props(['disabled' => false, 'id' => null])

<label
    class="flex cursor-pointer w-fit items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark [&:has(input:checked)]:text-on-surface-strong dark:[&:has(input:checked)]:text-on-surface-dark-strong [&:has(input:disabled)]:opacity-75 [&:has(input:disabled)]:cursor-not-allowed"
    for="{{ $id }}"
>
    <div class="relative flex items-center">
        <input
            id="{{ $id }}"
            {{ $disabled ? 'disabled' : '' }}
            {!!
                $attributes->merge([
                    'type' => 'checkbox',
                    'class' => "
                                            before:content[''] peer relative size-4 cursor-pointer
                                            appearance-none overflow-hidden focus:ring-0 rounded border
                                             border-outline bg-neutral-50 before:absolute before:inset-0
                                             checked:text-on-surface-strong checked:border-primary checked:before:bg-primary
                                            focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-outline-strong
                                            checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed
                                            dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark
                                            dark:checked:text-on-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark",
                ])
            !!}
        />
        <x-icons.check
            size="xs"
            strokeWidth="4"
            class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-on-primary peer-checked:visible dark:text-on-primary-dark"
        />
    </div>
    {{ $slot }}
</label>
