<div x-data="{ selectedItem: 'profile' }" class="flex flex-col animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <x-typography.heading accent size="xl" level="1" class="font-extrabold tracking-tight">
            {{ __('Account Settings') }}
        </x-typography.heading>
        <x-typography.subheading size="lg" class="text-on-surface/70 dark:text-on-surface-dark/70">
            {{ __('Manage your personal information, security preferences, and application settings.') }}
        </x-typography.subheading>
        <x-separator class="my-6 opacity-50" />
    </div>

    <div class="flex flex-col md:flex-row mt-2">
        <!-- Sidebar Navigation -->
        <div class="mr-12 w-full pb-8 md:w-[240px]">
            <nav>
                <ul class="flex flex-col gap-1.5">
                    @php
                        $navItems = [
                            'profile' => ['label' => __('Profile'), 'icon' => 'users'],
                            'password' => ['label' => __('Password'), 'icon' => 'shield'],
                            'appearance' => ['label' => __('Appearance'), 'icon' => 'swatch'],
                            'api-tokens' => ['label' => __('API Tokens'), 'icon' => 'cog'],
                            'ai-keys' => ['label' => __('AI Keys'), 'icon' => 'sparkles'],
                        ];
                    @endphp

                    @foreach ($navItems as $value => $item)
                        <li>
                            <button
                                x-on:click="selectedItem = '{{ $value }}'"
                                class="flex items-center w-full gap-3 px-4 py-2.5 rounded-radius font-semibold text-sm transition-all duration-200"
                                x-bind:class="
                                    selectedItem === '{{ $value }}'
                                        ? 'bg-primary text-white shadow-lg shadow-primary/25 dark:shadow-primary-dark/20'
                                        : 'text-on-surface/60 hover:text-on-surface-strong hover:bg-surface-alt dark:text-on-surface-dark/60 dark:hover:text-on-surface-dark-strong dark:hover:bg-surface-dark/40'
                                "
                            >
                                <div class="transition-colors" x-bind:class="selectedItem === '{{ $value }}' ? 'text-white' : 'text-on-surface/40 dark:text-on-surface-dark/40'">
                                    @if($item['icon'] === 'users') <x-icons.users class="size-4.5" />
                                    @elseif($item['icon'] === 'shield') <x-icons.shield class="size-4.5" />
                                    @elseif($item['icon'] === 'swatch') <x-icons.swatch class="size-4.5" />
                                    @elseif($item['icon'] === 'cog') <x-icons.cog class="size-4.5" />
                                    @elseif($item['icon'] === 'sparkles') <x-icons.sparkles class="size-4.5" />
                                    @endif
                                </div>
                                <span>{{ $item['label'] }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <!-- Mobile Separator -->
        <x-separator class="my-6 md:hidden opacity-50" />

        <!-- Content Area -->
        <div class="max-w-4xl space-y-6 w-full">
            <!-- Profile Section -->
            <div x-cloak x-show="selectedItem === 'profile'" class="animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="w-full">
                    @livewire('settings.profile')
                </div>
            </div>

            <!-- Password Section -->
            <div x-cloak x-show="selectedItem === 'password'" class="animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="w-full">
                    @livewire('settings.password')
                </div>
            </div>

            <!-- Appearance Section -->
            <div x-cloak x-show="selectedItem === 'appearance'" class="animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="w-full">
                    @livewire('settings.appearance')
                </div>
            </div>

            <!-- API Tokens Section -->
            <div x-cloak x-show="selectedItem === 'api-tokens'" class="animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="w-full">
                    @livewire('settings.api-tokens')
                </div>
            </div>

            <!-- AI Keys Section -->
            <div x-cloak x-show="selectedItem === 'ai-keys'" class="animate-in fade-in slide-in-from-right-4 duration-500">
                <div class="w-full">
                    @livewire('settings.ai-api-keys')
                </div>
            </div>
        </div>
    </div>
</div>
