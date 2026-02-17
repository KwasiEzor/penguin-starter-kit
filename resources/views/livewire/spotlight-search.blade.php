<div
    x-data="{
        showSearch: $wire.entangle('open'),
        init() {
            document.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    this.showSearch = true;
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                }
                if (e.key === 'Escape') {
                    this.showSearch = false;
                    $wire.close();
                }
            });
        }
    }"
>
    <!-- Backdrop -->
    <div x-cloak x-show="showSearch" x-transition.opacity
        class="fixed inset-0 z-50 bg-surface-dark/20 backdrop-blur-sm"
        x-on:click="showSearch = false; $wire.close()">
    </div>

    <!-- Search Dialog -->
    <div x-cloak x-show="showSearch" x-transition
        class="fixed inset-x-0 top-[20%] z-50 mx-auto w-full max-w-lg">
        <div class="mx-4 overflow-hidden rounded-radius border border-outline bg-surface shadow-2xl dark:border-outline-dark dark:bg-surface-dark">
            <!-- Search Input -->
            <div class="flex items-center gap-3 border-b border-outline px-4 dark:border-outline-dark">
                <svg class="size-5 shrink-0 text-on-surface dark:text-on-surface-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    x-ref="searchInput"
                    wire:model.live.debounce.200ms="query"
                    type="text"
                    placeholder="{{ __('Search posts, pages...') }}"
                    class="w-full border-0 bg-transparent py-3 text-sm text-on-surface-strong placeholder-on-surface/50 focus:outline-none focus:ring-0 dark:text-on-surface-dark-strong dark:placeholder-on-surface-dark/50"
                />
                <kbd class="hidden shrink-0 rounded border border-outline px-1.5 py-0.5 text-[10px] font-medium text-on-surface dark:border-outline-dark dark:text-on-surface-dark sm:inline">ESC</kbd>
            </div>

            <!-- Results -->
            <div class="max-h-80 overflow-y-auto">
                @if ($pages->count() && $query)
                    <div class="px-3 py-2">
                        <p class="px-1 text-xs font-medium uppercase tracking-wider text-on-surface dark:text-on-surface-dark">{{ __('Pages') }}</p>
                    </div>
                    @foreach ($pages as $page)
                        <a href="{{ $page['url'] }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2 text-sm text-on-surface hover:bg-primary/5 dark:text-on-surface-dark dark:hover:bg-primary-dark/5">
                            <x-dynamic-component :component="'icons.' . $page['icon']" size="sm" class="shrink-0" />
                            <span>{{ $page['name'] }}</span>
                        </a>
                    @endforeach
                @endif

                @if (count($results))
                    <div class="px-3 py-2 {{ $pages->count() ? 'border-t border-outline dark:border-outline-dark' : '' }}">
                        <p class="px-1 text-xs font-medium uppercase tracking-wider text-on-surface dark:text-on-surface-dark">{{ __('Posts') }}</p>
                    </div>
                    @foreach ($results as $post)
                        <a href="{{ route('posts.edit', $post) }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-primary/5 dark:hover:bg-primary-dark/5">
                            <x-icons.document-text size="sm" class="shrink-0 text-on-surface dark:text-on-surface-dark" />
                            <div class="flex-1 min-w-0">
                                <p class="truncate font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $post->title }}</p>
                                <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ ucfirst($post->status) }} &middot; {{ $post->created_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if (!count($results) && !$pages->count() && strlen($query) >= 2)
                    <div class="px-4 py-8 text-center text-sm text-on-surface dark:text-on-surface-dark">
                        {{ __('No results found for') }} "{{ $query }}"
                    </div>
                @endif

                @if (!$query)
                    <div class="px-4 py-6 text-center text-sm text-on-surface dark:text-on-surface-dark">
                        {{ __('Start typing to search...') }}
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between border-t border-outline px-4 py-2 text-xs text-on-surface dark:border-outline-dark dark:text-on-surface-dark">
                <span>{{ __('Search') }}</span>
                <span class="flex items-center gap-1">
                    <kbd class="rounded border border-outline px-1 py-0.5 font-mono dark:border-outline-dark">⌘</kbd>
                    <kbd class="rounded border border-outline px-1 py-0.5 font-mono dark:border-outline-dark">K</kbd>
                </span>
            </div>
        </div>
    </div>
</div>
