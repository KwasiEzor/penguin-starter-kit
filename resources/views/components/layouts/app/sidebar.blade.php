<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <x-rich-text::styles theme="richtextlaravel" />
    </head>

    <body x-data x-cloak class="min-h-screen bg-surface-alt dark:bg-surface-dark-alt">
        <div x-data="{ showSidebar: false }" class="relative flex w-full flex-col lg:flex-row min-h-screen">
            <!-- Skip to main content link -->
            <a class="sr-only" href="#main-content">{{ __('Skip to main content') }}</a>

            <x-sidebar />

            <!-- Main Content Area -->
            <div id="main-content" class="flex flex-1 flex-col min-w-0">
                <!-- Mobile Header -->
                <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-outline bg-surface/80 px-6 backdrop-blur-md lg:hidden dark:border-outline-dark dark:bg-surface-dark/80">
                    <button
                        x-on:click="showSidebar = true"
                        class="rounded-lg p-2 text-on-surface hover:bg-black/5 dark:text-on-surface-dark dark:hover:bg-white/5"
                    >
                        <x-icons.bars-3 variant="outline" size="md" />
                    </button>

                    <div class="flex items-center gap-4">
                        <x-avatar
                            :src="auth()->user()->avatarUrl()"
                            :initials="auth()->user()->initials()"
                            size="sm"
                        />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-6 lg:p-10 max-w-[1600px] w-full mx-auto">
                    {{ $slot }}
                </main>
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
