<div
    x-data="{
        notifications: [],
        displayDuration: 5000,

        addNotification({ content = '', type = 'info' }) {
            const id = Date.now()
            const notification = { id, content, type, paused: false, startTime: Date.now(), remaining: this.displayDuration }

            if (this.notifications.length >= 5) {
                this.notifications.splice(0, this.notifications.length - 4)
            }

            this.notifications.push(notification)
            this.scheduleRemoval(notification)
        },

        scheduleRemoval(notification) {
            setTimeout(() => {
                if (!notification.paused) {
                    this.removeNotification(notification.id)
                }
            }, notification.remaining)
        },

        pauseNotification(notification) {
            notification.paused = true
            notification.remaining = notification.remaining - (Date.now() - notification.startTime)
        },

        resumeNotification(notification) {
            notification.paused = false
            notification.startTime = Date.now()
            this.scheduleRemoval(notification)
        },

        removeNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id)
        },

        typeConfig(type) {
            const configs = {
                success: { icon: 'check-circle', bg: 'bg-success/10', border: 'border-success/20', text: 'text-success' },
                error: { icon: 'x-circle', bg: 'bg-danger/10', border: 'border-danger/20', text: 'text-danger' },
                warning: { icon: 'exclamation', bg: 'bg-warning/10', border: 'border-warning/20', text: 'text-warning' },
                info: { icon: 'info', bg: 'bg-info/10', border: 'border-info/20', text: 'text-info' },
            }
            return configs[type] || configs.info
        }
    }"
    x-on:notify.window="addNotification({ content: $event.detail.content, type: $event.detail.type })"
    x-init="
        const flash = {{ Js::from(session('notify')) }};
        if (flash) {
            setTimeout(() => addNotification(flash), 100);
        }
    "
    class="pointer-events-none fixed bottom-0 right-0 z-50 flex max-w-sm flex-col gap-2 p-6"
    role="status"
    aria-live="polite"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            x-on:mouseenter="pauseNotification(notification)"
            x-on:mouseleave="resumeNotification(notification)"
            class="pointer-events-auto flex w-full items-center gap-3 rounded-radius border bg-surface p-4 shadow-lg dark:bg-surface-dark"
            x-bind:class="notification.type === 'success' ? 'border-success/20' : notification.type === 'error' ? 'border-danger/20' : notification.type === 'warning' ? 'border-warning/20' : 'border-info/20'"
        >
            {{-- Icon --}}
            <div class="shrink-0">
                <template x-if="notification.type === 'success'">
                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </template>
                <template x-if="notification.type === 'error'">
                    <svg class="size-5 text-danger" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </template>
                <template x-if="notification.type === 'warning'">
                    <svg class="size-5 text-warning" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </template>
                <template x-if="notification.type === 'info'">
                    <svg class="size-5 text-info" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                </template>
            </div>

            {{-- Content --}}
            <p class="text-sm text-on-surface-strong dark:text-on-surface-dark-strong" x-text="notification.content"></p>

            {{-- Close --}}
            <button x-on:click="removeNotification(notification.id)" class="ml-auto shrink-0 text-on-surface hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:text-on-surface-dark-strong" aria-label="Dismiss notification">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
