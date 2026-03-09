<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body
        class="min-h-screen antialiased bg-surface dark:bg-linear-to-b dark:from-surface-dark dark:to-surface-dark-alt transition-colors duration-300"
    >
        <!-- Main Container -->
        <div
            class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0"
        >
            <!-- Left Side Panel (Premium Design) -->
            <div
                class="relative hidden h-full flex-col p-12 text-white lg:flex border-r border-outline/10 dark:border-outline-dark/10 overflow-hidden"
            >
                <!-- Background with Premium Gradient & Noise -->
                <div class="absolute inset-0 bg-primary-dark">
                    <div class="absolute inset-0 bg-linear-to-br from-primary via-primary-dark to-black opacity-90"></div>
                    <!-- Mesh Gradient Effect -->
                    <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] bg-secondary/20 rounded-full blur-[120px] animate-pulse"></div>
                    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-primary/30 rounded-full blur-[100px]"></div>
                    <!-- Subtle Pattern Overlay -->
                    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                </div>

                <!-- Logo Area -->
                <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-3 text-xl font-bold tracking-tight group">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 group-hover:scale-105 transition-transform duration-300">
                        <x-app-logo-icon class="h-7 fill-white" />
                    </div>
                    <span class="drop-shadow-sm">{{ config('app.name', 'Penguin') }}</span>
                </a>

                <!-- Quote Section -->
                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto max-w-lg">
                    <div class="mb-6 h-1 w-12 bg-white/30 rounded-full"></div>
                    <blockquote class="space-y-4">
                        <p class="text-2xl font-medium leading-tight tracking-tight opacity-90 italic">
                            &ldquo;{{ trim($message) }}&rdquo;
                        </p>
                        <footer class="flex items-center gap-3">
                            <div class="h-px w-4 bg-white/40"></div>
                            <span class="text-sm font-semibold tracking-wider uppercase opacity-70">{{ trim($author) }}</span>
                        </footer>
                    </blockquote>
                </div>

                <!-- Subtle Bottom Decor -->
                <div class="absolute bottom-12 right-12 z-20 flex gap-4 opacity-30">
                     <div class="size-2 rounded-full bg-white"></div>
                     <div class="size-2 rounded-full bg-white/50"></div>
                     <div class="size-2 rounded-full bg-white/20"></div>
                </div>
            </div>

            <!-- Right Side Content (Clean & Focused) -->
            <div class="w-full lg:p-8 flex items-center justify-center min-h-screen lg:min-h-0 bg-surface dark:bg-surface-dark">
                <div class="mx-auto flex w-full flex-col justify-center space-y-8 sm:w-[400px]">
                    <!-- Mobile Logo -->
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-bold lg:hidden mb-4">
                         <div class="flex size-14 items-center justify-center rounded-2xl bg-primary/10 dark:bg-primary-dark/10">
                            <x-app-logo-icon
                                class="size-9 fill-primary dark:fill-primary-dark"
                            />
                        </div>
                        <span class="text-2xl text-on-surface-strong dark:text-on-surface-dark-strong tracking-tight">{{ config('app.name', 'Penguin') }}</span>
                    </a>

                    <!-- Main Content Card -->
                    <div class="p-4 sm:p-0 transition-all duration-500 animate-fade-in">
                        {{ $slot }}
                    </div>

                    <!-- Footer Links for Auth -->
                    <div class="text-center text-xs text-on-surface/40 dark:text-on-surface-dark/40 px-8">
                         By continuing, you agree to our 
                         <a href="#" class="underline hover:text-primary">Terms</a> and 
                         <a href="#" class="underline hover:text-primary">Privacy Policy</a>.
                    </div>
                </div>
            </div>
        </div>

        <x-toast />

        @include('partials.scripts')
        @livewireScriptConfig
    </body>
</html>
