@props([
    'slides' => [],
    'autoPlay' => false,
    'interval' => 5000,
])

<div 
    x-data="{ 
        currentSlide: 0,
        totalSlides: {{ count($slides) }},
        autoPlay: @json($autoPlay),
        interval: {{ $interval }},
        timer: null,
        next() {
            this.currentSlide = (this.currentSlide === this.totalSlides - 1) ? 0 : this.currentSlide + 1;
        },
        prev() {
            this.currentSlide = (this.currentSlide === 0) ? this.totalSlides - 1 : this.currentSlide - 1;
        },
        goTo(index) {
            this.currentSlide = index;
        },
        startTimer() {
            if (this.autoPlay) {
                this.timer = setInterval(() => this.next(), this.interval);
            }
        },
        stopTimer() {
            clearInterval(this.timer);
        }
    }" 
    x-init="startTimer()"
    x-on:mouseenter="stopTimer()"
    x-on:mouseleave="startTimer()"
    class="relative overflow-hidden rounded-3xl group"
    {{ $attributes }}
>
    <!-- Slides -->
    <div class="relative h-full flex transition-transform duration-500 ease-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
        @foreach ($slides as $index => $slide)
            <div class="w-full shrink-0 relative overflow-hidden h-full">
                {{ $slide }}
            </div>
        @endforeach
    </div>

    <!-- Controls -->
    @if(count($slides) > 1)
        <button 
            @click="prev()" 
            class="absolute left-4 top-1/2 -translate-y-1/2 flex size-10 items-center justify-center rounded-full bg-surface/80 backdrop-blur-md border border-outline/50 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-surface dark:bg-surface-dark/80 dark:border-outline-dark/50"
            aria-label="Previous slide"
        >
            <x-icons.chevron-down class="rotate-90 text-on-surface-strong dark:text-on-surface-dark-strong" size="sm" />
        </button>

        <button 
            @click="next()" 
            class="absolute right-4 top-1/2 -translate-y-1/2 flex size-10 items-center justify-center rounded-full bg-surface/80 backdrop-blur-md border border-outline/50 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-surface dark:bg-surface-dark/80 dark:border-outline-dark/50"
            aria-label="Next slide"
        >
            <x-icons.chevron-down class="-rotate-90 text-on-surface-strong dark:text-on-surface-dark-strong" size="sm" />
        </button>

        <!-- Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
            @foreach ($slides as $index => $slide)
                <button 
                    @click="goTo({{ $index }})" 
                    class="h-1.5 transition-all duration-300 rounded-full"
                    :class="currentSlide === {{ $index }} ? 'w-8 bg-primary shadow-lg shadow-primary/30' : 'w-2 bg-on-surface/20 hover:bg-on-surface/40 dark:bg-on-surface-dark/20 dark:hover:bg-on-surface-dark/40'"
                    aria-label="Go to slide {{ $index + 1 }}"
                ></button>
            @endforeach
        </div>
    @endif
</div>
