@props([
    'vertical' => false,
    'text' => null,
    'strong' => false,
])

@php
    $borderClass = $strong
        ? 'border-outline-strong dark:border-outline-strong'
        : 'border-outline dark:border-outline-dark';
@endphp

@if ($text)
    <div class="flex items-center w-full">
        <div class="grow border-t {{ $borderClass }}"></div>
        <span class="shrink mx-6 text-sm text-on-surface dark:text-on-surface-dark">{{ $text }}</span>
        <div class="grow border-t {{ $borderClass }}"></div>
    </div>
@else
    <div
        {{ $attributes->class([
            'border-t' => !$vertical,
            'border-l h-full' => $vertical,
            $borderClass,
        ]) }}>
    </div>
@endif
