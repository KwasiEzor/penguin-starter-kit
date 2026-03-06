{{-- Credit: Heroicons (https://heroicons.com) --}}

@props([
    'variant' => 'outline',
    'size' => 'md',
    'ariaHidden' => true,
    'strokeWidth' => 1.5,
])

@php
    $sizes = [
        'xs' => 'size-3',
        'sm' => 'size-4',
        'md' => 'size-5',
        'lg' => 'size-6',
        'xl' => 'size-7',
    ];

    $sizeClass = array_key_exists($size, $sizes) ? $sizes[$size] : $size;
@endphp

@switch($variant)
    @case('outline')
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="{{ $strokeWidth }}"
            stroke="currentColor"
            {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        @break

    @case('solid')
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            {{ $attributes->class($sizeClass) }}
            aria-hidden="{{ $ariaHidden }}"
        >
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.889c-.005.005-.01.01-.015.015a.75.75 0 0 0 1.054 1.068l.007-.007c.143-.141.48-.344 1.174-.344.456 0 .846.115 1.082.327.228.206.294.443.294.619 0 .216-.098.453-.444.744a6.228 6.228 0 0 1-1.115.742 5.03 5.03 0 0 0-1.517 1.036c-.427.439-.696 1.058-.696 1.916v.125a.75.75 0 0 0 1.5 0v-.125c0-.342.106-.588.37-.858.21-.213.554-.45 1.01-.739 1.09-.69 1.97-1.522 1.97-2.851 0-1.077-.558-2.031-1.392-2.527V6Z" clip-rule="evenodd" />
            <path d="M13.5 16.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
        </svg>
        @break
@endswitch
