@props([
    'name' => '',
])

<button
    x-on:click="activeTab = '{{ $name }}'"
    x-on:keydown.arrow-right.prevent="$el.nextElementSibling?.focus()"
    x-on:keydown.arrow-left.prevent="$el.previousElementSibling?.focus()"
    x-on:keydown.home.prevent="$el.parentElement.firstElementChild?.focus()"
    x-on:keydown.end.prevent="$el.parentElement.lastElementChild?.focus()"
    x-bind:class="
        activeTab === '{{ $name }}'
            ? 'border-primary text-on-surface-strong dark:border-primary-dark dark:text-on-surface-dark-strong'
            : 'border-transparent text-on-surface hover:text-on-surface-strong hover:border-outline dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong dark:hover:border-outline-dark'
    "
    {{ $attributes->merge(['class' => '-mb-px border-b-2 px-4 py-2 text-sm font-medium transition-colors focus:outline-hidden focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark']) }}
    role="tab"
    x-bind:tabindex="activeTab === '{{ $name }}' ? 0 : -1"
    x-bind:aria-selected="activeTab === '{{ $name }}'"
>
    {{ $slot }}
</button>
