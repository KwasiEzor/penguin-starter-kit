<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @stack('meta')
    </head>

    <body class="min-h-screen antialiased bg-surface dark:bg-surface-dark">
        <!-- Navigation -->
        <nav class="border-b border-outline dark:border-outline-dark">
            <div class="mx-auto flex max-w-4xl items-center justify-between px-6 py-4">
                <a
                    href="{{ route('home') }}"
                    class="flex items-center gap-2 text-lg font-medium text-on-surface-strong dark:text-on-surface-dark-strong"
                >
                    <x-app-logo-icon class="h-7 fill-current" />
                    {{ config('app.name', 'Penguin Starter Kit') }}
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="text-sm text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark"
                            wire:navigate
                        >
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="text-sm text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark"
                            wire:navigate
                        >
                            {{ __('Login') }}
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="mx-auto max-w-4xl px-6 py-10">
            {{ $slot }}
        </main>

        <x-toast />

        @include('partials.scripts')
        @livewireScriptConfig
    </body>
</html>
