<div class="flex flex-col gap-10 pb-20">
    <!-- Page Header -->
    <div class="flex flex-col gap-2">
        <h1 class="text-4xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('UI Component Playground') }}
        </h1>
        <p class="text-lg font-medium text-on-surface/60 dark:text-on-surface-dark/60">
            {{ __('Explore and test the enhanced Penguin UI components.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
        <!-- Section: Avatars & Groups -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Avatars & Groups') }}
            </h2>
            <x-card>
                <div class="flex flex-col gap-8">
                    <!-- Sizes -->
                    <div class="space-y-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-on-surface/40">{{ __('Sizes & Status') }}</span>
                        <div class="flex items-end gap-4">
                            <x-avatar size="xs" status="online" initials="XS" />
                            <x-avatar size="sm" status="away" initials="SM" />
                            <x-avatar size="md" status="busy" initials="MD" />
                            <x-avatar size="lg" status="offline" initials="LG" />
                            <x-avatar size="xl" status="online" initials="XL" />
                            <x-avatar size="2xl" status="online" initials="2X" />
                        </div>
                    </div>

                    <!-- Groups -->
                    <div class="space-y-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-on-surface/40">{{ __('Avatar Groups') }}</span>
                        <div class="flex flex-col gap-4">
                            <x-avatar-group>
                                <x-avatar size="md" initials="JD" border />
                                <x-avatar size="md" initials="AS" border />
                                <x-avatar size="md" initials="MK" border />
                                <x-avatar size="md" initials="WL" border />
                            </x-avatar-group>

                            <x-avatar-group :limit="3" :total="12">
                                <x-avatar size="md" initials="A" border />
                                <x-avatar size="md" initials="B" border />
                                <x-avatar size="md" initials="C" border />
                            </x-avatar-group>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Section: Progress & Skeletons -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Progress & Skeletons') }}
            </h2>
            <x-card>
                <div class="flex flex-col gap-8">
                    <!-- Progress -->
                    <div class="space-y-4">
                        <x-progress :value="45" label="Uploading Assets" showValue />
                        <x-progress :value="75" variant="success" size="sm" label="Task Completion" />
                        <x-progress :value="30" variant="danger" size="xs" />
                    </div>

                    <!-- Skeletons -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <x-skeleton variant="circle" class="size-12" />
                            <div class="flex-1 space-y-2">
                                <x-skeleton class="h-4 w-1/3" />
                                <x-skeleton class="h-3 w-1/2" />
                            </div>
                        </div>
                        <x-skeleton variant="wave" class="h-32 w-full" />
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Section: Accordion -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Accordions') }}
            </h2>
            <x-accordion active="item-1">
                <x-accordion-item id="item-1" title="What is Penguin Starter Kit?">
                    {{ __('Penguin is a premium TALL stack starter kit designed for rapid SaaS development with a focus on high-end aesthetics and developer experience.') }}
                </x-accordion-item>
                <x-accordion-item id="item-2" title="How does the theming system work?">
                    {{ __('Our theming system uses Tailwind v4 CSS variables combined with a dynamic ThemeService that generates real-time CSS overrides based on user preferences.') }}
                </x-accordion-item>
                <x-accordion-item id="item-3" title="Is it production ready?">
                    {{ __('Absolutely. It comes with built-in authentication, role management, API documentation, health monitoring, and more.') }}
                </x-accordion-item>
            </x-accordion>
        </div>

        <!-- Section: Carousel -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Carousels') }}
            </h2>
            <div class="h-64">
                <x-carousel :autoPlay="true" :interval="4000" :count="3" class="h-full">
                    <x-carousel-item class="flex h-full items-center justify-center bg-primary/10 p-10 text-center">
                        <div>
                            <h3 class="text-2xl font-black text-primary">{{ __('First Slide') }}</h3>
                            <p class="mt-2 text-primary/60">{{ __('Animated with smooth Alpine.js transitions.') }}</p>
                        </div>
                    </x-carousel-item>
                    <x-carousel-item class="flex h-full items-center justify-center bg-secondary/10 p-10 text-center">
                        <div>
                            <h3 class="text-2xl font-black text-secondary">{{ __('Second Slide') }}</h3>
                            <p class="mt-2 text-secondary/60">{{ __('Fully responsive and touch-friendly.') }}</p>
                        </div>
                    </x-carousel-item>
                    <x-carousel-item class="flex h-full items-center justify-center bg-success/10 p-10 text-center">
                        <div>
                            <h3 class="text-2xl font-black text-success">{{ __('Third Slide') }}</h3>
                            <p class="mt-2 text-success/60">{{ __('Customize intervals and auto-play settings.') }}</p>
                        </div>
                    </x-carousel-item>
                </x-carousel>
            </div>
        </div>
        <!-- Section: Steps -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Guided Steps') }}
            </h2>
            <x-card>
                <x-steps>
                    <x-step number="1" title="Onboarding" description="Complete your profile and account setup." completed />
                    <x-step number="2" title="Verification" description="Verify your email and phone number." active />
                    <x-step number="3" title="Success" description="You are all set and ready to go!" isLast />
                </x-steps>
            </x-card>
        </div>

        <!-- Section: Badges & Tags -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Badges & Tags') }}
            </h2>
            <x-card>
                <div class="flex flex-wrap gap-4">
                    <x-badge variant="primary">Primary</x-badge>
                    <x-badge variant="success">Success</x-badge>
                    <x-badge variant="warning">Warning</x-badge>
                    <x-badge variant="danger">Danger</x-badge>
                    <x-badge variant="info">Info</x-badge>
                    <x-badge variant="default">Default</x-badge>
                </div>
            </x-card>
        </div>
    </div>
</div>
