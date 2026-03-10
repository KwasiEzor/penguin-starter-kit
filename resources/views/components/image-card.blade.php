@props([
    'src',
    'alt' => '',
    'aspect' => 'aspect-video',
    'contain' => false,
    'hoverEffect' => true,
    'animation' => 'animate-fade-in-up',
])

<div
    {{ $attributes->merge(['class' => 'relative group overflow-hidden rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark transition-all duration-700 ' . ($hoverEffect ? 'hover:shadow-2xl hover:shadow-primary/20 hover:-translate-y-2 hover:border-primary/50' : '') . ' ' . $animation]) }}>
    <div class="{{ $aspect }} overflow-hidden flex items-center justify-center p-6 relative">
        <!-- Glow effect behind image on hover -->
        <div
            class="absolute inset-0 bg-primary/10 rounded-full blur-2xl opacity-0 group-hover:opacity-40 transition-opacity duration-1000">
        </div>

        <img src="{{ $src }}" alt="{{ $alt }}" @class([
            'relative z-10 transition-all duration-700 group-hover:scale-110 drop-shadow-md group-hover:drop-shadow-xl',
            'h-full w-full object-cover' => !$contain,
            'max-h-full max-w-full object-contain' => $contain,
        ])
            onerror="this.src='https://placehold.co/400x300/f3f4f6/334155?text={{ urlencode($alt ?: 'Image') }}'" />
    </div>

    @if ($slot->isNotEmpty())
        <div
            class="relative z-10 p-6 border-t border-outline/30 dark:border-outline-dark/30 bg-surface/50 dark:bg-surface-dark-alt/50 backdrop-blur-sm transition-colors duration-500 group-hover:bg-primary/5">
            {{ $slot }}
        </div>
    @endif

    <!-- Overlay on hover -->
    <div
        class="absolute inset-0 bg-linear-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
    </div>
</div>
