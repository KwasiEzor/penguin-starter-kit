<div class="animate-in fade-in duration-500">
    <x-card class="overflow-hidden border-none shadow-premium-lg ring-1 ring-outline/5 dark:ring-outline-dark/5" 
        x-data="{
            theme: localStorage.theme || 'system',
            updateTheme(newTheme) {
                this.theme = newTheme
                localStorage.theme = newTheme

                if (newTheme === 'dark') {
                    document.documentElement.classList.add('dark')
                } else if (newTheme === 'light') {
                    document.documentElement.classList.remove('dark')
                } else {
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                        ? document.documentElement.classList.add('dark')
                        : document.documentElement.classList.remove('dark')
                }
            },
        }"
    >
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 dark:bg-primary-dark/10 rounded-radius text-primary dark:text-primary-dark">
                    <x-icons.swatch class="size-5" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="font-bold">
                        {{ __('Appearance') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm">
                        {{ __('Personalize the visual experience of your account.') }}
                    </x-typography.subheading>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $baseClasses =
                    'relative flex flex-col items-center gap-4 rounded-radius p-6 border-2 transition-all duration-200 cursor-pointer group';
                $stateClasses =
                    'peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:ring-4 peer-checked:ring-primary/10 dark:peer-checked:border-primary-dark dark:peer-checked:bg-primary-dark/5 dark:peer-checked:ring-primary-dark/10 border-outline/40 hover:border-primary/40 dark:border-outline-dark/40 dark:hover:border-primary-dark/40';
            @endphp

            <!-- Light Theme Option -->
            <label class="relative">
                <input
                    type="radio"
                    id="theme_light"
                    name="theme"
                    value="light"
                    class="sr-only peer"
                    x-model="theme"
                    x-on:change="updateTheme('light')"
                />
                <div class="{{ $baseClasses }} {{ $stateClasses }}">
                    <div class="p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-full text-on-surface dark:text-on-surface-dark group-hover:scale-110 transition-transform duration-300">
                        <x-icons.sun variant="solid" class="size-8" />
                    </div>
                    <div class="font-bold text-sm tracking-wide uppercase">{{ __('Light') }}</div>
                    
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                        <x-icons.check-circle class="size-6 text-primary dark:text-primary-dark" />
                    </div>
                </div>
            </label>

            <!-- Dark Theme Option -->
            <label class="relative">
                <input
                    type="radio"
                    id="theme_dark"
                    name="theme"
                    value="dark"
                    class="sr-only peer"
                    x-model="theme"
                    x-on:change="updateTheme('dark')"
                />
                <div class="{{ $baseClasses }} {{ $stateClasses }}">
                    <div class="p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-full text-on-surface dark:text-on-surface-dark group-hover:scale-110 transition-transform duration-300">
                        <x-icons.moon variant="solid" class="size-8" />
                    </div>
                    <div class="font-bold text-sm tracking-wide uppercase">{{ __('Dark') }}</div>
                    
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                        <x-icons.check-circle class="size-6 text-primary dark:text-primary-dark" />
                    </div>
                </div>
            </label>

            <!-- System Theme Option -->
            <label class="relative">
                <input
                    type="radio"
                    id="theme_system"
                    name="theme"
                    value="system"
                    class="sr-only peer"
                    x-model="theme"
                    x-on:change="updateTheme('system')"
                />
                <div class="{{ $baseClasses }} {{ $stateClasses }}">
                    <div class="p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-full text-on-surface dark:text-on-surface-dark group-hover:scale-110 transition-transform duration-300">
                        <x-icons.computer-desktop variant="solid" class="size-8" />
                    </div>
                    <div class="font-bold text-sm tracking-wide uppercase">{{ __('System') }}</div>
                    
                    <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity">
                        <x-icons.check-circle class="size-6 text-primary dark:text-primary-dark" />
                    </div>
                </div>
            </label>
        </div>
    </x-card>
</div>
