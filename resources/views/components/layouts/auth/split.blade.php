<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen antialiased bg-surface dark:bg-linear-to-b dark:from-surface-dark dark:to-surface-dark-alt">
    <!-- Main Container -->
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <!-- Left Side Panel -->
        <div
            class="relative hidden h-full flex-col p-10 text-on-surface-dark lg:flex dark:border-r dark:border-outline-dark">
            <!-- Background -->
            <div class="absolute inset-0 bg-surface-dark-alt"></div>

            <!-- Logo -->
            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium">
                <span class="flex size-10 items-center justify-center rounded-radius">
                    <x-app-logo-icon class="mr-2 h-7 fill-current text-on-surface-dark-strong" />
                </span>
                {{ config('app.name', 'Penguin Starter Kit') }}
            </a>

            <!-- Quote Section -->
            @php
                [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
            @endphp

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <p class="text-lg">&ldquo;{{ trim($message) }}&rdquo;</p>
                    <footer class="text-sm">{{ trim($author) }}</footer>
                </blockquote>
            </div>
        </div>

        <!-- Right Side Content -->
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <!-- Mobile Logo -->
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium lg:hidden">
                    <x-app-logo-icon
                        class="size-9 fill-current text-on-surface-strong dark:text-on-surface-dark-strong" />
                    <span class="sr-only">{{ config('app.name', 'Penguin Starter Kit') }}</span>
                </a>

                <!-- Main Content -->
                {{ $slot }}
            </div>
        </div>
    </div>

    <x-toast />

    @include('partials.scripts')
    @livewireScriptConfig
</body>

</html>
