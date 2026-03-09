@props([
    'number',
    'title' => '',
    'description' => '',
    'active' => false,
    'completed' => false,
    'isLast' => false,
])

<div {{ $attributes->merge(['class' => 'relative flex gap-8 group']) }}>
    <!-- Vertical Line -->
    @unless($isLast)
        <div class="absolute left-4.5 top-10 h-[calc(100%+2rem)] w-px bg-outline dark:bg-outline-dark lg:left-5.5 lg:top-12"></div>
    @endunless

    <!-- Step Circle -->
    <div @class([
        'relative z-10 flex size-9 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-500 lg:size-11',
        'border-primary bg-primary text-white shadow-lg shadow-primary/20' => $active,
        'border-success bg-success text-white shadow-lg shadow-success/20' => $completed,
        'border-outline bg-surface-alt text-on-surface/40 dark:border-outline-dark dark:bg-surface-dark dark:text-on-surface-dark/40' => ! $active && ! $completed,
    ])>
        @if ($completed)
            <x-icons.check variant="outline" size="sm" />
        @else
            <span class="text-xs font-black lg:text-sm">{{ $number }}</span>
        @endif
    </div>

    <!-- Step Content -->
    <div class="flex flex-col pt-1 lg:pt-2">
        <h3 @class([
            'text-sm font-black tracking-tight transition-colors duration-500 lg:text-base',
            'text-primary' => $active,
            'text-success' => $completed,
            'text-on-surface-strong dark:text-on-surface-dark-strong' => ! $active && ! $completed,
        ])>
            {{ $title }}
        </h3>
        @if ($description)
            <p class="mt-1 text-xs leading-relaxed text-on-surface/60 lg:text-sm">
                {{ $description }}
            </p>
        @endif
        @if ($slot->isNotEmpty())
            <div class="mt-4">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
