<section
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
    <header>
        <x-typography.heading class="mb-2" accent>{{ __('Appearance') }}</x-typography.heading>
        <x-typography.subheading>
            {{ __('Update the appearance settings for your account') }}
        </x-typography.subheading>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        @php
            $baseClasses =
                'relative flex items-center gap-4 rounded-radius p-2 border border-outline dark:border-outline-dark bg-surface-alt dark:bg-surface-dark-alt text-on-surface dark:text-on-surface-dark';
            $stateClasses =
                'has-checked:border-primary has-checked:bg-primary/5 has-checked:text-on-surface-strong has-checked:border has-focus:outline-2 has-focus:outline-offset-2 has-focus:outline-primary dark:has-checked:border-primary-dark dark:has-checked:text-on-surface-dark-strong dark:has-checked:bg-primary-dark/5 dark:has-focus:outline-primary-dark';
        @endphp

        <!-- Light Theme Option -->
        <label class="{{ $baseClasses }} {{ $stateClasses }}">
            <input
                type="radio"
                id="theme_light"
                name="theme"
                value="light"
                class="sr-only peer"
                x-model="theme"
                x-on:change="updateTheme('light')"
            />
            <x-icons.check size="sm" strokeWidth="2" class="peer-checked:visible invisible shrink-0" />
            <x-icons.sun variant="solid" size="lg" class="opacity-70 shrink-0" />
            <div class="font-medium">{{ __('Light') }}</div>
        </label>

        <!-- Dark Theme Option -->
        <label class="{{ $baseClasses }} {{ $stateClasses }}">
            <input
                type="radio"
                id="theme_dark"
                name="theme"
                value="dark"
                class="sr-only peer"
                x-model="theme"
                x-on:change="updateTheme('dark')"
            />
            <x-icons.check size="sm" strokeWidth="2" class="peer-checked:visible invisible shrink-0" />
            <x-icons.moon variant="solid" size="lg" class="opacity-70 shrink-0" />
            <div class="font-medium">{{ __('Dark') }}</div>
        </label>

        <!-- System Theme Option -->
        <label class="{{ $baseClasses }} {{ $stateClasses }}">
            <input
                type="radio"
                id="theme_system"
                name="theme"
                value="system"
                class="sr-only peer"
                x-model="theme"
                x-on:change="updateTheme('system')"
            />
            <x-icons.check size="sm" strokeWidth="2" class="peer-checked:visible invisible shrink-0" />
            <x-icons.computer-desktop variant="solid" size="lg" class="opacity-70 shrink-0" />
            <div class="font-medium">{{ __('System') }}</div>
        </label>
    </div>
</section>
