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
        <svg {{ $attributes->class($sizeClass) }} data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="{{ $strokeWidth }}" stroke="currentColor" aria-hidden="{{ $ariaHidden }}" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
    @break

    @case('solid')
        <svg {{ $attributes->class($sizeClass) }} data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="currentColor" aria-hidden="{{ $ariaHidden }}" data-slot="icon">
            <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('mini')
        <svg {{ $attributes->class($sizeClass) }} data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor" aria-hidden="{{ $ariaHidden }}" data-slot="icon">
            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
        </svg>
    @break

    @case('micro')
        <svg {{ $attributes->class($sizeClass) }} data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
            fill="currentColor" aria-hidden="{{ $ariaHidden }}" data-slot="icon">
            <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
        </svg>
    @break
@endswitch
