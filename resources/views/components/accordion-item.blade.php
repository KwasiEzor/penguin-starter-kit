@props([
    'id',
    'title' => '',
])

<div 
    x-data="{ id: '{{ $id }}' }"
    :class="isSelected(id) ? 'bg-surface dark:bg-surface-dark border-primary/20 ring-1 ring-primary/5' : 'bg-surface-alt/50 dark:bg-surface-dark/40 border-outline dark:border-outline-dark'"
    class="rounded-2xl border transition-all duration-300"
    {{ $attributes }}
>
    <button
        @click="toggle(id)"
        type="button"
        class="flex w-full items-center justify-between px-6 py-4 text-left"
        aria-expanded="false"
        :aria-expanded="isSelected(id)"
    >
        <span 
            class="text-sm font-bold tracking-tight transition-colors duration-300"
            :class="isSelected(id) ? 'text-primary' : 'text-on-surface-strong dark:text-on-surface-dark-strong'"
        >
            {{ $title }}
        </span>
        <span 
            class="ml-4 flex-shrink-0 transition-transform duration-300"
            :class="isSelected(id) ? 'rotate-180 text-primary' : 'text-on-surface/40 dark:text-on-surface-dark/40'"
        >
            <x-icons.chevron-down variant="outline" size="sm" />
        </span>
    </button>

    <div
        x-show="isSelected(id)"
        x-collapse
        x-cloak
    >
        <div class="px-6 pb-5 pt-0 text-sm leading-relaxed text-on-surface/70 dark:text-on-surface-dark/70">
            {{ $slot }}
        </div>
    </div>
</div>
