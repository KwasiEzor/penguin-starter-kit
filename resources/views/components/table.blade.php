@props([])

<div {{ $attributes->merge(['class' => 'w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark']) }}>
    <table class="w-full text-sm text-left">
        @isset($head)
            <thead class="border-b border-outline bg-surface-alt text-xs font-medium uppercase tracking-wider text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                <tr>{{ $head }}</tr>
            </thead>
        @endisset
        <tbody class="divide-y divide-outline bg-surface dark:divide-outline-dark dark:bg-surface-dark">
            {{ $slot }}
        </tbody>
    </table>
</div>
