@props(['maxWidth' => '2xl', 'show' => false])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div x-data="{ modalIsOpen: @js($show ?? false) }">
    {{ $trigger }}
    <div
        x-cloak
        x-show="modalIsOpen"
        x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="modalIsOpen"
        x-on:keydown.esc.window="modalIsOpen = false"
        x-on:click.self="modalIsOpen = false"
        class="fixed inset-0 z-99 flex items-start justify-center bg-surface-dark/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
        role="dialog"
        aria-modal="true"
    >
        <!-- Modal Dialog -->
        <div
            x-show="modalIsOpen"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="flex {{ $maxWidth }} flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark"
        >
            <!-- Dialog Header -->
            <div
                class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark-alt/20"
            >
                @isset($header)
                    {{ $header }}
                @endisset

                <button x-on:click="modalIsOpen = false" class="ml-auto" aria-label="close modal">
                    <x-icons.x-mark />
                </button>
            </div>
            <!-- Dialog Body -->
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
