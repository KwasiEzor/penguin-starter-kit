<div x-data="{ selectedItem: 'profile' }" class="flex flex-col">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <x-typography.heading accent size="xl" level="1">
            {{ __('Settings') }}
        </x-typography.heading>
        <x-typography.subheading size="lg">
            {{ __('Manage your profile and account settings') }}
        </x-typography.subheading>
        <x-separator class="my-4" />
    </div>

    <div class="flex flex-col md:flex-row mt-4">
        <!-- Sidebar Navigation -->
        <div class="mr-10 w-full pb-4 md:w-[220px]">
            <ul class="flex flex-col gap-1">
                @php
                    $navItems = [
                        'profile' => __('Profile'),
                        'password' => __('Password'),
                        'appearance' => __('Appearance'),
                        'api-tokens' => __('API Tokens'),
                    ];
                @endphp

                @foreach ($navItems as $value => $label)
                    <li>
                        <button
                            x-on:click="selectedItem = '{{ $value }}'"
                            class="flex items-center w-full gap-4 px-4 py-2 rounded-radius font-medium text-sm underline-offset-2 focus:outline-hidden focus:underline"
                            x-bind:class="
                                selectedItem === '{{ $value }}'
                                    ? 'bg-primary/10 pointer-events-none text-on-surface-strong dark:bg-primary-dark/10 dark:text-on-surface-dark-strong'
                                    : 'hover:bg-primary/5 text-on-surface hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong'
                            "
                        >
                            <span>{{ $label }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Mobile Separator -->
        <x-separator class="my-4 md:hidden" />

        <!-- Content Area -->
        <div class="max-w-7xl space-y-6 w-full">
            <!-- Profile Section -->
            <div x-cloak x-show="selectedItem === 'profile'">
                <div class="w-full max-w-xl">
                    @livewire('settings.profile')
                </div>
            </div>

            <!-- Password Section -->
            <div x-cloak x-show="selectedItem === 'password'">
                <div class="w-full max-w-xl">
                    @livewire('settings.password')
                </div>
            </div>

            <!-- Appearance Section -->
            <div x-cloak x-show="selectedItem === 'appearance'">
                <div class="w-full max-w-xl">
                    @livewire('settings.appearance')
                </div>
            </div>

            <!-- API Tokens Section -->
            <div x-cloak x-show="selectedItem === 'api-tokens'">
                <div class="w-full max-w-xl">
                    @livewire('settings.api-tokens')
                </div>
            </div>
        </div>
    </div>
</div>
