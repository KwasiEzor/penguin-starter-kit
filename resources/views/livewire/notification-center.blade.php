<div x-data="{ open: false }" class="relative">
    <!-- Bell Button — styled like a sidebar link -->
    <button
        x-on:click="open = !open"
        x-bind:class="
            open
                ? 'bg-primary/10 dark:bg-primary-dark/10 text-on-surface-strong dark:text-on-surface-dark-strong'
                : ''
        "
        class="flex w-full items-center gap-4 rounded-radius px-4 py-2 text-sm font-medium text-on-surface hover:bg-primary/5 hover:text-on-surface-strong focus:outline-hidden dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong"
        aria-label="Notifications"
    >
        <svg
            class="size-5 shrink-0"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
            />
        </svg>
        <span class="flex-1 text-left">{{ __('Notifications') }}</span>
        @if ($unreadCount > 0)
            <span
                class="ml-auto flex size-5 shrink-0 items-center justify-center rounded-full bg-danger text-[10px] font-bold text-on-danger"
            >
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown — opens upward on the right (desktop) or upward inline (mobile) -->
    <div
        x-cloak
        x-show="open"
        x-on:click.outside="open = false"
        x-transition
        class="absolute bottom-0 left-full z-50 ml-2 w-80 rounded-radius border border-outline bg-surface shadow-lg dark:border-outline-dark dark:bg-surface-dark-alt max-lg:bottom-full max-lg:left-0 max-lg:ml-0 max-lg:mb-2 max-lg:w-full"
    >
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-outline px-4 py-3 dark:border-outline-dark">
            <span class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Notifications') }}
            </span>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-primary hover:underline dark:text-primary-dark">
                    {{ __('Mark all read') }}
                </button>
            @endif
        </div>

        <!-- List -->
        <div class="max-h-64 overflow-y-auto sm:max-h-80">
            @forelse ($notifications as $notification)
                <div
                    wire:key="notification-{{ $notification->id }}"
                    class="flex items-start gap-3 border-b border-outline/50 px-4 py-3 last:border-0 dark:border-outline-dark/50 {{ $notification->unread() ? 'bg-primary/5 dark:bg-primary-dark/5' : '' }}"
                >
                    <div class="flex-1 min-w-0">
                        <p
                            class="truncate text-sm text-on-surface-strong dark:text-on-surface-dark-strong {{ $notification->unread() ? 'font-medium' : '' }}"
                        >
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </p>
                        <p class="mt-0.5 text-xs text-on-surface dark:text-on-surface-dark">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if ($notification->unread())
                        <button
                            wire:click="markAsRead('{{ $notification->id }}')"
                            class="mt-1 shrink-0 text-xs text-primary hover:underline dark:text-primary-dark"
                        >
                            {{ __('Read') }}
                        </button>
                    @endif
                </div>
            @empty
                <div class="px-4 py-8 text-center text-sm text-on-surface dark:text-on-surface-dark">
                    {{ __('No notifications yet.') }}
                </div>
            @endforelse
        </div>
    </div>
</div>
