@props([
    'label',
    'value',
    'icon' => null,
    'color' => 'primary',
    'href' => null,
    'change' => null,
    'trend' => null, // 'up', 'down', 'neutral'
])

@php
    $colorClasses = match ($color) {
        'primary' => 'bg-primary/10 text-primary dark:bg-primary-dark/20 dark:text-primary-dark',
        'info' => 'bg-info/10 text-info dark:bg-info/20',
        'success' => 'bg-success/10 text-success dark:bg-success/20',
        'warning' => 'bg-warning/10 text-warning dark:bg-warning/20',
        'danger' => 'bg-danger/10 text-danger dark:bg-danger/20',
        default => 'bg-primary/10 text-primary dark:bg-primary-dark/20 dark:text-primary-dark',
    };
@endphp

<div {{ $attributes->merge(['class' => 'group relative overflow-hidden rounded-radius border border-outline bg-surface p-6 shadow-premium transition-all duration-300 hover:shadow-xl hover:-translate-y-1 dark:border-outline-dark dark:bg-surface-dark-alt']) }}>
    <div class="flex items-start justify-between">
        <div class="space-y-1">
            <span class="text-[11px] font-bold uppercase tracking-widest text-on-surface/50 dark:text-on-surface-dark/50">
                {{ $label }}
            </span>
            <h2 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ $value }}
            </h2>
            
            @if($change)
                <div @class([
                    'flex items-center gap-1 text-xs font-bold mt-2',
                    'text-success' => ($trend ?? 'up') === 'up',
                    'text-danger' => ($trend ?? 'up') === 'down',
                    'text-on-surface/50' => ($trend ?? 'up') === 'neutral',
                ])>
                    @if(($trend ?? 'up') === 'up')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                        </svg>
                    @elseif(($trend ?? 'up') === 'down')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                            <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                        </svg>
                    @endif
                    <span>{{ $change }}</span>
                </div>
            @endif
        </div>

        @if ($icon)
            <div class="flex size-12 items-center justify-center rounded-2xl {{ $colorClasses }} transition-transform duration-300 group-hover:scale-110">
                {{ $icon }}
            </div>
        @endif
    </div>

    @if ($href)
        <a href="{{ $href }}" class="absolute inset-0 z-10" aria-label="{{ $label }}" wire:navigate></a>
    @endif
    
    <!-- Subtle Background Accent -->
    <div class="absolute -right-4 -bottom-4 size-24 rounded-full {{ $colorClasses }} opacity-5 blur-3xl transition-opacity group-hover:opacity-10"></div>
</div>
