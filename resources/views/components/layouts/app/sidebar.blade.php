<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body x-data x-cloak class="min-h-screen bg-surface dark:bg-surface-dark-alt">
        <div x-data="{ showSidebar: false }" class="relative flex w-full flex-col lg:flex-row">
            <!-- Skip to main content link -->
            <a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

            <x-sidebar />

            <!-- Main Content -->
            <div id="main-content" class="h-svh w-full overflow-y-auto bg-surface-alt dark:bg-surface-dark-alt">
                <!-- Mobile Header -->
                <div class="lg:hidden pt-6 px-8 flex justify-between">
                    <button
                        x-cloak
                        x-on:click="showSidebar = ! showSidebar"
                        class="whitespace-nowrap rounded-radius p-2 text-sm font-medium tracking-wide text-on-surface text-center hover:bg-primary/10 hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-surface-alt active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:hover:bg-primary-dark/10 dark:text-on-surface-dark-strong dark:focus-visible:outline-surface-dark-alt"
                    >
                        <x-icons.bars-3 x-cloak variant="outline" stroke-width="2" size="lg" />
                    </button>

                    <!-- Mobile Dropdown -->
                    <x-dropdown>
                        <x-slot:trigger>
                            <button
                                class="rounded-radius cursor-pointer bg-transparent hover:bg-surface-alt dark:hover:bg-surface/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark"
                                aria-controls="userMenu"
                            >
                                <div class="flex items-center p-0.5">
                                    <x-avatar
                                        :src="auth()->user()->avatarUrl()"
                                        :initials="auth()->user()->initials()"
                                        size="sm"
                                    />
                                    <div class="p-1 text-on-surface-strong dark:text-on-surface-dark-strong">
                                        <x-icons.chevron-down variant="micro" size="sm" />
                                    </div>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot:content>
                            <ul>
                                <li class="border-b border-outline dark:border-outline-dark">
                                    <div class="flex flex-col px-4 py-2">
                                        <span
                                            class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong"
                                        >
                                            {{ auth()->user()->name }}
                                        </span>
                                        <p class="text-xs text-on-surface dark:text-on-surface-dark">
                                            {{ auth()->user()->email }}
                                        </p>
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
                                        <x-dropdown-link
                                            :href="route('logout')"
                                            onclick="
                                                event.preventDefault();
                                                this.closest('form').submit();
                                            "
                                        >
                                            <x-icons.arrow-right-start-on-rectangle variant="mini" />
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>
                            </ul>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{ $slot }}
            </div>
        </div>

        @auth
            @livewire('spotlight-search')
        @endauth

        <x-toast />

        @include('partials.scripts')
        @livewireScriptConfig
    </body>
</html>
