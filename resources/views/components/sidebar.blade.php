<!-- Dark overlay -->
<div
    x-cloak
    x-show="showSidebar"
    x-on:click="showSidebar = false"
    x-transition.opacity
    class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
    aria-hidden="true"
></div>

<!-- Sidebar Navigation -->
<nav
    x-cloak
    x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed left-0 z-50 flex h-screen w-72 shrink-0 flex-col border-r border-outline bg-surface-alt p-6 transition-transform duration-300 lg:sticky lg:top-0 dark:border-outline-dark dark:bg-surface-dark"
    aria-label="sidebar navigation"
>
    <!-- Mobile close button -->
    <button
        x-cloak
        x-on:click="showSidebar = false"
        class="absolute right-4 top-4 block lg:hidden rounded-full p-2 text-on-surface hover:bg-black/5 dark:text-on-surface-dark dark:hover:bg-white/5"
    >
        <x-icons.x-mark variant="outline" size="md" />
    </button>

    <!-- Brand Header -->
    <div class="mb-8 flex items-center gap-3">
        <div class="flex size-10 items-center justify-center rounded-xl bg-primary shadow-lg shadow-primary/20">
            <x-app-logo class="size-6 text-white" />
        </div>
        <div class="flex flex-col">
            <span class="text-lg font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">Penguin</span>
            <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface/50 dark:text-on-surface-dark/50">Starter Kit</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="flex flex-col gap-8 overflow-y-auto h-full pr-2 -mr-2">
        <!-- Section: Main -->
        <div class="flex flex-col gap-3">
            <h3 class="px-3 text-[11px] font-bold uppercase tracking-widest text-on-surface/40 dark:text-on-surface-dark/40">
                {{ __('Platform') }}
            </h3>
            <ul class="flex flex-col gap-1">
                <li>
                    <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <x-icons.home variant="outline" size="sm" />
                        <span>{{ __('Dashboard') }}</span>
                    </x-sidebar-link>
                </li>
                <li>
                    <x-sidebar-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">
                        <x-icons.document-text variant="outline" size="sm" />
                        <span>{{ __('Posts') }}</span>
                    </x-sidebar-link>
                </li>
                @can('admin.access')
                    <li>
                        <x-sidebar-link href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')">
                            <x-icons.tag variant="outline" size="sm" />
                            <span>{{ __('Categories') }}</span>
                        </x-sidebar-link>
                    </li>
                @endcan
                <li>
                    <x-sidebar-link href="{{ route('agents.index') }}" :active="request()->routeIs('agents.*')">
                        <x-icons.sparkles variant="outline" size="sm" />
                        <span>{{ __('AI Agents') }}</span>
                    </x-sidebar-link>
                </li>
            </ul>
        </div>

        @can('admin.access')
            <!-- Section: Admin -->
            <div class="flex flex-col gap-3">
                <h3 class="px-3 text-[11px] font-bold uppercase tracking-widest text-on-surface/40 dark:text-on-surface-dark/40">
                    {{ __('Management') }}
                </h3>
                <ul class="flex flex-col gap-1">
                    <li>
                        <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                            <x-icons.shield variant="outline" size="sm" />
                            <span>{{ __('Admin Panel') }}</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                            <x-icons.users variant="outline" size="sm" />
                            <span>{{ __('User Manager') }}</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('admin.theme') }}" :active="request()->routeIs('admin.theme')">
                            <x-icons.swatch variant="outline" size="sm" />
                            <span>{{ __('Theme Settings') }}</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('admin.playground') }}" :active="request()->routeIs('admin.playground')">
                            <x-icons.sparkles variant="outline" size="sm" />
                            <span>{{ __('UI Playground') }}</span>
                        </x-sidebar-link>
                    </li>
                    <li>
                        <x-sidebar-link href="{{ route('admin.health') }}" :active="request()->routeIs('admin.health')">
                            <x-icons.heart variant="outline" size="sm" />
                            <span>{{ __('System Health') }}</span>
                        </x-sidebar-link>
                    </li>
                </ul>
            </div>
        @endcan

        @if (\App\Models\Setting::paymentsEnabled())
            <!-- Section: Sales -->
            <div class="flex flex-col gap-3">
                <h3 class="px-3 text-[11px] font-bold uppercase tracking-widest text-on-surface/40 dark:text-on-surface-dark/40">
                    {{ __('Billing') }}
                </h3>
                <ul class="flex flex-col gap-1">
                    <li>
                        <x-sidebar-link href="{{ route('billing') }}" :active="request()->routeIs('billing')">
                            <x-icons.credit-card variant="outline" size="sm" />
                            <span>{{ __('My Subscriptions') }}</span>
                        </x-sidebar-link>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Section: Support -->
        <div class="mt-auto flex flex-col gap-1 border-t border-outline pt-6 dark:border-outline-dark">
            <x-sidebar-link href="https://github.com/KwasiEzor/penguin-starter-kit" target="_blank">
                <x-icons.folder-git-2 size="sm" />
                <span>{{ __('GitHub Repo') }}</span>
            </x-sidebar-link>
            <x-sidebar-link href="{{ url('/docs/api') }}">
                <x-icons.book-open-text size="sm" />
                <span>{{ __('API Reference') }}</span>
            </x-sidebar-link>
        </div>
    </div>

    <!-- User Profile Footer -->
    <div class="mt-6 border-t border-outline pt-6 dark:border-outline-dark">
        <x-dropdown align="bottom-14 left-0 lg:left-0 lg:bottom-16">
            <x-slot:trigger>
                <button type="button" class="group flex w-full items-center gap-3 rounded-xl p-2 transition-all hover:bg-black/5 dark:hover:bg-white/5 text-left">
                    <x-avatar :src="auth()->user()->avatarUrl()" :initials="auth()->user()->initials()" size="sm" />
                    <div class="flex flex-col overflow-hidden">
                        <span class="truncate text-sm font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="truncate text-xs text-on-surface/60 dark:text-on-surface-dark/60">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                    <x-icons.chevron-up-down size="sm" class="ml-auto text-on-surface/40 group-hover:text-on-surface/70" />
                </button>
            </x-slot>

            <x-slot:content>
                <div class="w-56 p-1">
                    <x-dropdown-link href="{{ route('settings') }}">
                        <x-icons.cog variant="mini" />
                        {{ __('Personal Settings') }}
                    </x-dropdown-link>
                    <div class="my-1 border-t border-outline dark:border-outline-dark"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            <x-icons.arrow-right-start-on-rectangle variant="mini" class="text-danger" />
                            <span class="text-danger">{{ __('Log Out') }}</span>
                        </x-dropdown-link>
                    </form>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
