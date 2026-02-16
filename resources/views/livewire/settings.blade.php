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
                    ];
                @endphp

                @foreach ($navItems as $value => $label)
                    <li>
                        <button x-on:click="selectedItem = '{{ $value }}'"
                            class="flex items-center w-full gap-4 px-4 py-2 rounded-radius font-medium text-sm underline-offset-2 focus:outline-hidden focus:underline"
                            x-bind:class="selectedItem === '{{ $value }}'
                                ?
                                'bg-primary/10 pointer-events-none text-on-surface-strong dark:bg-primary-dark/10 dark:text-on-surface-dark-strong' :
                                'hover:bg-primary/5 text-on-surface hover:text-on-surface-strong dark:text-on-surface-dark dark:hover:bg-primary-dark/5 dark:hover:text-on-surface-dark-strong'">
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

            <!-- Delete Account Section -->
            <div x-show="selectedItem === 'profile'">
                <div class="mt-5 w-full max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <x-typography.heading class="mb-2" accent>{{ __('Delete account') }}</x-typography.heading>
                            <x-typography.subheading>{{ __('Delete your account and all of its resources') }}</x-typography.subheading>
                        </header>
                        <x-modal name="confirm-user-deletion" :maxWidth="'lg'">
                            <x-slot name="trigger">
                                <x-button variant="danger" x-on:click="modalIsOpen = true">{{ __('Delete Account') }}</x-button>
                            </x-slot>
                            <x-slot name="header">
                                <x-typography.subheading accent size="lg">{{ __('Are you sure you want to delete your account?') }}</x-typography.subheading>
                            </x-slot>
                            <div class="p-4">
                                <p class="text-sm text-on-surface dark:text-on-surface-dark">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>
                                <div class="mt-6">
                                    <x-input-label for="delete-password" value="{{ __('Password') }}" class="sr-only" />
                                    <x-input variant="password" id="delete-password" placeholder="{{ __('Password') }}" class="block w-3/4"
                                        type="password" wire:model="deletePassword" required />
                                    <x-input-error :messages="$errors->get('deletePassword')" class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-4 flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                                <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false">
                                    {{ __('Cancel') }}
                                </x-button>
                                <x-button variant="danger" type="button" wire:click="deleteAccount">
                                    {{ __('Delete Account') }}
                                </x-button>
                            </div>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
