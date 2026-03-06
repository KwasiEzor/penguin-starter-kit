@props([])

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    {{-- Desktop: standard table --}}
    <div class="hidden overflow-x-auto rounded-radius border border-outline dark:border-outline-dark sm:block">
        <table class="w-full text-sm text-left">
            @isset($head)
                <thead
                    class="border-b border-outline bg-surface-alt text-xs font-medium uppercase tracking-wider text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark"
                >
                    <tr>{{ $head }}</tr>
                </thead>
            @endisset

            <tbody class="divide-y divide-outline bg-surface dark:divide-outline-dark dark:bg-surface-dark">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    {{-- Mobile: stacked cards --}}
    <div class="flex flex-col gap-3 sm:hidden">
        {{ $mobile ?? '' }}
    </div>
</div>
