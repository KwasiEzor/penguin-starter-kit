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
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
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
            <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h17.25v-.75a3 3 0 0 0-3-3h-11.25Z" />
            <path fill-rule="evenodd" d="M1.5 9.75V17.25a3 3 0 0 0 3 3h11.25a3 3 0 0 0 3-3V9.75H1.5ZM4.875 13.5a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5h-6Zm0 3a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
        </svg>
        @break
@endswitch
