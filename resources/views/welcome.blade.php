<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-surface dark:bg-surface-dark selection:bg-primary/20 transition-colors duration-300 antialiased overflow-x-hidden">
        
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 glass border-b border-outline/30 dark:border-outline-dark/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-2">
                        <x-app-logo class="h-8 w-auto text-primary dark:text-primary-dark" />
                    </div>
                    
                    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-on-surface/70 dark:text-on-surface-dark/70">
                        <a href="#features" class="hover:text-primary transition-colors">{{ __('Features') }}</a>
                        <a href="#about" class="hover:text-primary transition-colors">{{ __('About') }}</a>
                        @auth
                            <x-button variant="primary" size="sm" href="{{ route('dashboard') }}">
                                {{ __('Dashboard') }}
                            </x-button>
                        @else
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="hover:text-primary transition-colors" wire:navigate>{{ __('Log in') }}</a>
                                <x-button variant="primary" size="sm" href="{{ route('register') }}">
                                    {{ __('Get Started') }}
                                </x-button>
                            </div>
                        @endauth
                    </div>

                    <!-- Mobile menu button (Simplified) -->
                    <div class="md:hidden flex items-center">
                         @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-primary">{{ __('Dashboard') }}</a>
                         @else
                            <a href="{{ route('login') }}" class="text-sm font-medium">{{ __('Log in') }}</a>
                         @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main>
            <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
                <!-- Background Decoration -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none">
                    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[120px] opacity-50 dark:opacity-20 animate-pulse"></div>
                    <div class="absolute bottom-0 right-[-10%] w-[30%] h-[30%] bg-secondary/10 rounded-full blur-[100px] opacity-40 dark:opacity-20"></div>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/5 border border-primary/10 text-primary text-xs font-semibold mb-8 animate-fade-in-up">
                        <x-icons.sparkles class="size-3.5" />
                        <span>{{ __('The ultimate Laravel starter kit is here') }}</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong mb-6 leading-[1.1]">
                        Build <span class="text-primary dark:text-primary-dark">outstanding</span> apps <br class="hidden lg:block" /> faster than ever.
                    </h1>
                    
                    <p class="max-w-2xl mx-auto text-lg lg:text-xl text-on-surface/60 dark:text-on-surface-dark/60 mb-10 leading-relaxed">
                        Penguin Starter Kit provides a premium foundation for your next SaaS. Built with TALL stack, AI-ready, and designed for excellence.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 200ms;">
                        <x-button variant="primary" size="lg" class="px-8" href="{{ route('register') }}">
                            {{ __('Start Building for Free') }}
                        </x-button>
                        <x-button variant="outline" size="lg" class="px-8" href="#features">
                             <x-icons.book-open-text class="size-5 mr-2" />
                            {{ __('Explore Features') }}
                        </x-button>
                    </div>

                    <!-- App Preview / Dashboard Mockup -->
                    <div class="mt-20 relative mx-auto max-w-5xl group">
                         <div class="absolute -inset-1 bg-linear-to-r from-primary to-secondary rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                         <div class="relative bg-surface dark:bg-surface-dark-alt rounded-xl border border-outline dark:border-outline-dark overflow-hidden shadow-2xl shadow-primary/10 transition-transform duration-700 group-hover:scale-[1.01]">
                            <img src="/admin-dashboard.png" alt="Admin Dashboard" class="w-full h-auto" onerror="this.src='https://placehold.co/1200x800/222/white?text=Premium+Dashboard+Preview'" />
                         </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-24 bg-surface-alt dark:bg-surface-dark/50 border-y border-outline/30 dark:border-outline-dark/30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl lg:text-4xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong mb-4">{{ __('Everything you need to ship') }}</h2>
                        <p class="text-on-surface/60 dark:text-on-surface-dark/60 max-w-2xl mx-auto">
                            Stop wasting time on boilerplate. We've built the core features so you can focus on your unique value proposition.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.sparkles class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('AI Powered') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Pre-configured AI agent integration. Generate content, automate tasks, and build intelligent features out of the box.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.shield class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Enterprise Ready') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Robust RBAC with Spatie Permissions, advanced authentication, and security best practices implemented.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.swatch class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Modern UI') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Beautiful, responsive components built with Tailwind CSS v4 and Livewire. Dark mode is standard.
                            </p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.credit-card class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Billing Integrated') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Subscription management and payments handled with Laravel Cashier (Stripe). Ready for global revenue.
                            </p>
                        </div>

                        <!-- Feature 5 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.magnifying-glass class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Search & SEO') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Global spotlight search and full SEO meta management for your posts and pages. Get indexed faster.
                            </p>
                        </div>

                        <!-- Feature 6 -->
                        <div class="p-8 rounded-2xl bg-surface dark:bg-surface-dark-alt border border-outline dark:border-outline-dark hover:border-primary/50 dark:hover:border-primary-dark/50 transition-all group">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <x-icons.arrow-path class="size-6" />
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Real-time Notifications') }}</h3>
                            <p class="text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed text-sm">
                                Integrated notification center with Laravel Reverb support. Keep your users engaged in real-time.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tech Stack Section -->
            <section class="py-20 overflow-hidden bg-surface dark:bg-surface-dark">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                     <div class="text-center mb-12">
                        <p class="text-xs font-bold uppercase tracking-widest text-primary/60 mb-4">{{ __('Powered by the best') }}</p>
                    </div>
                    <div class="flex flex-wrap justify-center items-center gap-12 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                         <!-- Placeholders for logos -->
                         <span class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">LARAVEL</span>
                         <span class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">LIVEWIRE</span>
                         <span class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">TAILWIND</span>
                         <span class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">STRIPE</span>
                         <span class="text-2xl font-black text-on-surface-strong dark:text-on-surface-dark-strong">POSTGRES</span>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 px-4">
                <div class="max-w-4xl mx-auto relative p-12 lg:p-20 rounded-3xl overflow-hidden bg-primary text-on-primary text-center">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-64 h-64 bg-black/10 rounded-full blur-3xl"></div>
                    
                    <h2 class="text-3xl lg:text-5xl font-bold mb-6 relative z-10">{{ __('Ready to launch your outstanding project?') }}</h2>
                    <p class="text-on-primary/80 mb-10 text-lg relative z-10">
                        Join hundreds of developers who ship faster and better with Penguin.
                    </p>
                    <div class="relative z-10 flex flex-col sm:flex-row justify-center gap-4">
                        <x-button variant="secondary" size="lg" class="px-10 bg-white text-primary hover:bg-white/90" href="{{ route('register') }}">
                            {{ __('Get Started Now') }}
                        </x-button>
                         <x-button variant="outline" size="lg" class="px-10 border-white text-white hover:bg-white/10">
                            {{ __('View Demo') }}
                        </x-button>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="py-12 border-t border-outline/30 dark:border-outline-dark/30 bg-surface-alt dark:bg-surface-dark-alt">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center gap-2">
                        <x-app-logo class="h-6 w-auto text-primary dark:text-primary-dark" />
                    </div>
                    
                    <div class="flex gap-8 text-sm text-on-surface/50 dark:text-on-surface-dark/50">
                        <a href="#" class="hover:text-primary transition-colors">Twitter</a>
                        <a href="#" class="hover:text-primary transition-colors">GitHub</a>
                        <a href="#" class="hover:text-primary transition-colors">Discord</a>
                    </div>
                    
                    <p class="text-sm text-on-surface/40 dark:text-on-surface-dark/40">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>

        @livewireScriptConfig
    </body>
</html>
