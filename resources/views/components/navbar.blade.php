<nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false"
    class="bg-surface-alt border-b border-outline dark:border-outline-dark px-6 py-2.5 dark:bg-surface-dark"
    aria-label="penguin ui menu">
    <div class="flex items-center justify-between [:where(&)]:max-w-7xl mx-auto">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0">
            <x-app-logo class="size-8" />
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden items-center gap-4 sm:flex">
            <li>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-nav-link>
            </li>
            <li>
                <x-nav-link href="https://github.com/laravel/livewire-starter-kit"
                    target="_blank">{{ __('Repository') }}</x-nav-link>
            </li>
            <li>
                <x-nav-link href="https://laravel.com/docs/starter-kits"
                    target="_blank">{{ __('Docs') }}</x-nav-link>
            </li>

            <x-dropdown>
                <x-slot:trigger>
                    <button
                        class="rounded-radius cursor-pointer bg-transparent hover:bg-surface-alt dark:hover:bg-surface/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark"
                        aria-controls="userMenu">

                        <div class="flex items-center p-0.5">
                            <span
                                class="flex size-8 text-sm font-medium items-center justify-center overflow-hidden rounded-radius border border-outline bg-surface-alt tracking-wider text-on-surface/80 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark/80">
                                {{ auth()->user()->initials() }}</span>

                            <div class="p-1 text-on-surface-strong dark:text-on-surface-dark-strong">
                                <x-icons.chevron-down variant="micro" size="sm" />
                            </div>

                        </div>
                    </button>
                </x-slot>

                <x-slot:content>
                    <li class="border-b border-outline dark:border-outline-dark">
                        <div class="flex flex-col px-4 py-2">
                            <span
                                class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ auth()->user()->name }}</span>
                            <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ auth()->user()->email }}
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
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                <x-icons.arrow-right-start-on-rectangle variant="mini" />
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                </x-slot>
            </x-dropdown>
        </ul>

        <!-- Mobile Menu Button -->
        <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen"
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
            class="flex text-on-surface dark:text-on-surface-dark sm:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
            <x-icons.bars-3 x-cloak x-show="!mobileMenuIsOpen" variant="outline" stroke-width="2" size="lg" />
            <x-icons.x-mark x-cloak x-show="mobileMenuIsOpen" variant="outline" stroke-width="2" size="lg" />
        </button>

        <!-- Mobile Menu -->
        <ul x-cloak x-show="mobileMenuIsOpen"
            x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
            x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full"
            class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-radius border-b border-outline bg-surface-alt px-8 pb-6 pt-10 dark:border-outline-dark dark:bg-surface-dark-alt sm:hidden">
            <li class="mb-4 border-none">
                <div class="flex items-center gap-3 py-2">
                    <span
                        class="flex size-10 text-sm font-medium items-center justify-center overflow-hidden rounded-radius border border-outline bg-surface-alt tracking-wider text-on-surface/80 dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark/80">
                        {{ auth()->user()->initials() }}</span>

                    <div>
                        <span
                            class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ auth()->user()->name }}</span>
                        <p class="text-sm text-on-surface dark:text-on-surface-dark">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </li>
            <li class="p-2">
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </li>
            <li class="p-2">
                <x-responsive-nav-link href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </x-responsive-nav-link>
            </li>
            <li class="p-2">
                <x-responsive-nav-link href="https://laravel.com/docs/starter-kits" target="_blank">
                    {{ __('Docs') }}
                </x-responsive-nav-link>
            </li>
            <li>
                <hr role="none" class="my-2 border-outline dark:border-outline-dark">
            </li>
            <li class="p-2">
                <x-responsive-nav-link href="{{ route('settings') }}">
                    <x-icons.cog variant="mini" />
                    {{ __('Settings') }}
                </x-responsive-nav-link>
            </li>
            <li class="p-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        <x-icons.arrow-right-start-on-rectangle variant="mini" />
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </li>
        </ul>
    </div>
</nav>
