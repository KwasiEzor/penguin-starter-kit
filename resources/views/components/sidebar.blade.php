<!-- Dark overlay -->
<div x-cloak x-show="showSidebar" x-on:click="showSidebar = false" x-transition.opacity
    class="fixed inset-0 z-10 bg-surface-dark/10 backdrop-blur-xs lg:hidden" aria-hidden="true"></div>

<!-- Sidebar Navigation -->
<nav x-cloak x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'"
    class="fixed left-0 z-20 flex h-svh w-60 shrink-0 flex-col border-r border-outline bg-surface p-4 transition-transform duration-300 lg:w-64 lg:translate-x-0 lg:relative dark:border-outline-dark dark:bg-surface-dark"
    aria-label="sidebar navigation">
    <!-- Mobile close button -->
    <button x-cloak x-on:click="showSidebar = false"
        class="block lg:hidden whitespace-nowrap w-fit mb-4 rounded-radius p-2 text-sm font-medium tracking-wide text-on-surface text-center hover:bg-primary/10 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:hover:bg-primary-dark/10 dark:text-on-surface-dark-strong dark:focus-visible:outline-surface-dark-alt">
        <x-icons.x-mark variant="outline" size="md" />
    </button>

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="mb-4 flex items-center space-x-2 lg:ml-0">
        <x-app-logo class="size-8" />
    </a>

    <!-- Platform Label -->
    <div class="px-1 py-2">
        <div class="text-xs leading-none text-on-surface dark:text-on-surface-dark">{{ __('Platform') }}</div>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col gap-2 overflow-y-auto pb-6 h-full">
        <!-- Main Navigation -->
        <ul class="flex flex-col gap-2">
            <li>
                <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-icons.home variant="outline" />
                    <span>{{ __('Dashboard') }}</span>
                </x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">
                    <x-icons.document-text variant="outline" />
                    <span>{{ __('Posts') }}</span>
                </x-sidebar-link>
            </li>
        </ul>

        @can('admin.access')
            <!-- Admin Section -->
            <div class="px-1 py-2 mt-4">
                <div class="text-xs leading-none text-on-surface dark:text-on-surface-dark">{{ __('Admin') }}</div>
            </div>
            <ul class="flex flex-col gap-2">
                <li>
                    <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        <x-icons.shield variant="outline" />
                        <span>{{ __('Dashboard') }}</span>
                    </x-sidebar-link>
                </li>
                <li>
                    <x-sidebar-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <span>{{ __('Users') }}</span>
                    </x-sidebar-link>
                </li>
                <li>
                    <x-sidebar-link href="{{ route('admin.roles.index') }}" :active="request()->routeIs('admin.roles.*')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>
                        <span>{{ __('Roles') }}</span>
                    </x-sidebar-link>
                </li>
            </ul>
        @endcan

        <!-- Bottom Navigation -->
        <ul class="flex flex-col gap-2 mt-auto">
            <li>
                <x-sidebar-link href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    <x-icons.folder-git-2 />
                    <span>{{ __('Repository') }}</span>
                </x-sidebar-link>
            </li>
            <li>
                <x-sidebar-link href="https://laravel.com/docs/starter-kits" target="_blank">
                    <x-icons.book-open-text />
                    <span>{{ __('Documentation') }}</span>
                </x-sidebar-link>
            </li>
        </ul>
    </div>

    <!-- Notification Center -->
    <div class="mb-2 flex justify-start px-2">
        @livewire('notification-center')
    </div>

    <!-- User Dropdown -->
    <x-dropdown align="bottom-14 left-0 lg:left-full lg:ml-2 lg:bottom-0">
        <x-slot:trigger>
            <button type="button" x-bind:class="dropDownIsOpen ? 'bg-primary/10 dark:bg-primary-dark/10' : ''"
                class="flex w-full items-center gap-2 rounded-radius p-2 text-left text-on-surface hover:bg-primary/5 hover:text-on-surface-strong focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:outline-primary-dark">
                <div class="flex items-center gap-3">
                    <x-avatar :src="auth()->user()->avatarUrl()" :initials="auth()->user()->initials()" size="sm" />
                    <span
                        class="text-sm text-on-surface-strong dark:text-on-surface-dark-strong">{{ auth()->user()->name }}</span>
                </div>
                <x-icons.chevron-right strokeWidth="2" size="sm" class="ml-auto shrink-0 -rotate-90 lg:rotate-0" />
            </button>
        </x-slot:trigger>

        <x-slot:content>
            <ul>
                <li class="border-b border-outline dark:border-outline-dark">
                    <div class="flex flex-col px-4 py-2">
                        <span
                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ auth()->user()->name }}</span>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ auth()->user()->email }}</p>
                    </div>
                </li>
                <li>
                    <x-dropdown-link href="{{ route('settings') }}">
                        <x-icons.cog variant="mini" />
                        {{ __('Settings') }}
                    </x-dropdown-link>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <x-icons.arrow-right-start-on-rectangle variant="mini" />
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </x-slot:content>
    </x-dropdown>
</nav>
