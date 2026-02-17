@props([
    'wire' => null,
    'accept' => 'image/*',
    'label' => __('Upload a file'),
    'hint' => __('PNG, JPG, GIF up to 2MB'),
    'preview' => null,
    'removable' => false,
    'removeAction' => null,
])

<div x-data="{ dragging: false }" class="w-full">
    @if ($preview)
        <div class="relative inline-block">
            <img src="{{ $preview }}" alt="Preview" class="h-32 w-32 rounded-radius border border-outline object-cover dark:border-outline-dark" />
            @if ($removable && $removeAction)
                <button type="button" wire:click="{{ $removeAction }}"
                    class="absolute -right-2 -top-2 flex size-6 items-center justify-center rounded-full bg-danger text-on-primary shadow-sm hover:bg-danger/80">
                    <x-icons.x-mark variant="micro" size="sm" />
                </button>
            @endif
        </div>
    @else
        <label
            x-on:dragover.prevent="dragging = true"
            x-on:dragleave.prevent="dragging = false"
            x-on:drop.prevent="dragging = false; if ($event.dataTransfer.files.length) $refs.input.files = $event.dataTransfer.files; $refs.input.dispatchEvent(new Event('change', { bubbles: true }))"
            x-bind:class="dragging ? 'border-primary dark:border-primary-dark bg-primary/5 dark:bg-primary-dark/5' : 'border-outline dark:border-outline-dark'"
            {{ $attributes->merge(['class' => 'flex cursor-pointer flex-col items-center justify-center rounded-radius border-2 border-dashed p-6 transition-colors hover:border-primary dark:hover:border-primary-dark']) }}
        >
            <div class="flex flex-col items-center gap-2 text-center">
                <div class="rounded-full bg-surface-alt p-2 dark:bg-surface-dark-alt">
                    <svg class="size-6 text-on-surface/60 dark:text-on-surface-dark/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $label }}</p>
                    <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ $hint }}</p>
                </div>
            </div>
            <input x-ref="input" type="file" accept="{{ $accept }}" class="sr-only"
                @if ($wire) wire:model="{{ $wire }}" @endif />
        </label>
    @endif
</div>
