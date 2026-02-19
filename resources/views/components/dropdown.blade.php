@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'mt-2 flex flex-col overflow-hidden rounded-radius border border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        'right' => 'ltr:origin-top-right rtl:origin-top-left end-0',
        default => $align,
    };

    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div
    class="relative"
    x-data="{ dropDownIsOpen: false, openWithKeyboard: false }"
    x-on:keydown.esc.window="dropDownIsOpen = false, openWithKeyboard = false"
>
    <div
        x-on:click="dropDownIsOpen = ! dropDownIsOpen"
        x-on:keydown.space.prevent="openWithKeyboard = true"
        x-on:keydown.enter.prevent="openWithKeyboard = true"
        x-on:keydown.down.prevent="openWithKeyboard = true"
    >
        {{ $trigger }}
    </div>

    <div
        x-cloak
        x-show="dropDownIsOpen || openWithKeyboard"
        x-transition.opacity
        x-trap="openWithKeyboard"
        x-on:click.outside="dropDownIsOpen = false, openWithKeyboard = false"
        x-on:keydown.down.prevent="$focus.wrap().next()"
        x-on:keydown.up.prevent="$focus.wrap().previous()"
        class="absolute z-10 {{ $alignmentClasses }} {{ $width }} {{ $contentClasses }}"
    >
        {{ $content }}
    </div>
</div>
