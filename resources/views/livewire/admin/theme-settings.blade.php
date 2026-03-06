<div
    x-data="{
        applyPreview() {
            const root = document.documentElement.style

            // Light colors
            root.setProperty('--color-surface', $wire.lightSurface)
            root.setProperty('--color-surface-alt', $wire.lightSurfaceAlt)
            root.setProperty('--color-on-surface', $wire.lightOnSurface)
            root.setProperty('--color-on-surface-strong', $wire.lightOnSurfaceStrong)
            root.setProperty('--color-primary', $wire.lightPrimary)
            root.setProperty('--color-on-primary', $wire.lightOnPrimary)
            root.setProperty('--color-secondary', $wire.lightSecondary)
            root.setProperty('--color-on-secondary', $wire.lightOnSecondary)
            root.setProperty('--color-outline', $wire.lightOutline)
            root.setProperty('--color-outline-strong', $wire.lightOutlineStrong)

            // Dark colors
            root.setProperty('--color-surface-dark', $wire.darkSurface)
            root.setProperty('--color-surface-dark-alt', $wire.darkSurfaceAlt)
            root.setProperty('--color-on-surface-dark', $wire.darkOnSurface)
            root.setProperty('--color-on-surface-dark-strong', $wire.darkOnSurfaceStrong)
            root.setProperty('--color-primary-dark', $wire.darkPrimary)
            root.setProperty('--color-on-primary-dark', $wire.darkOnPrimary)
            root.setProperty('--color-secondary-dark', $wire.darkSecondary)
            root.setProperty('--color-on-secondary-dark', $wire.darkOnSecondary)
            root.setProperty('--color-outline-dark', $wire.darkOutline)
            root.setProperty('--color-outline-dark-strong', $wire.darkOutlineStrong)

            // Semantic colors
            root.setProperty('--color-info', $wire.semanticInfo)
            root.setProperty('--color-on-info', $wire.semanticOnInfo)
            root.setProperty('--color-success', $wire.semanticSuccess)
            root.setProperty('--color-on-success', $wire.semanticOnSuccess)
            root.setProperty('--color-warning', $wire.semanticWarning)
            root.setProperty('--color-on-warning', $wire.semanticOnWarning)
            root.setProperty('--color-danger', $wire.semanticDanger)
            root.setProperty('--color-on-danger', $wire.semanticOnDanger)

            // Effects
            root.setProperty('--radius-radius', $wire.radius)
            root.setProperty('--default-transition-duration', $wire.speed)

            // Font
            const fontFamily = $wire.fontFamily
            root.setProperty('--font-sans', `'${fontFamily}', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'`)
        },
    }"
    x-effect="applyPreview()"
    class="flex flex-col gap-6"
>
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Theme') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Theme Customization') }}</x-typography.heading>
        <x-typography.subheading size="lg">
            {{ __('Customize colors, fonts, and effects for your application') }}
        </x-typography.subheading>
    </div>

    <x-separator />

    <x-tabs active="presets">
        <x-slot name="tabs">
            <x-tab name="presets">{{ __('Presets') }}</x-tab>
            <x-tab name="colors">{{ __('Colors') }}</x-tab>
            <x-tab name="typography">{{ __('Typography & Effects') }}</x-tab>
        </x-slot>

        <!-- Presets Tab -->
        <x-tab-panel name="presets">
            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($presets as $key => $presetData)
                        <button
                            type="button"
                            wire:click="applyPreset('{{ $key }}')"
                            @class([
                                'flex flex-col gap-3 rounded-radius border p-4 text-left transition-colors',
                                'border-primary bg-primary/5 dark:border-primary-dark dark:bg-primary-dark/5' => $preset === $key,
                                'border-outline hover:border-outline-strong dark:border-outline-dark dark:hover:border-outline-dark-strong' => $preset !== $key,
                            ])
                        >
                            <div>
                                <div class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                    {{ $presetData['name'] }}
                                </div>
                                <div class="text-xs text-on-surface dark:text-on-surface-dark">
                                    {{ $presetData['description'] }}
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['light']['primary'] }}"
                                ></span>
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['light']['secondary'] }}"
                                ></span>
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['light']['surface'] }}"
                                ></span>
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['light']['surface-alt'] }}"
                                ></span>
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['dark']['primary'] }}"
                                ></span>
                                <span
                                    class="size-6 rounded-full border border-outline/30"
                                    style="background-color: {{ $presetData['colors']['dark']['surface'] }}"
                                ></span>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="flex items-center gap-2">
                    <x-button wire:click="saveTheme">{{ __('Save Theme') }}</x-button>
                    <x-button variant="outline" wire:click="resetToDefault">{{ __('Reset to Default') }}</x-button>
                </div>
            </div>
        </x-tab-panel>

        <!-- Colors Tab -->
        <x-tab-panel name="colors">
            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Light Mode Colors -->
                    <x-card>
                        <x-slot name="header">
                            <x-typography.heading accent>{{ __('Light Mode') }}</x-typography.heading>
                        </x-slot>

                        <div class="flex flex-col gap-4">
                            @foreach ([
                                'lightSurface' => 'Surface',
                                'lightSurfaceAlt' => 'Surface Alt',
                                'lightOnSurface' => 'On Surface',
                                'lightOnSurfaceStrong' => 'On Surface Strong',
                                'lightPrimary' => 'Primary',
                                'lightOnPrimary' => 'On Primary',
                                'lightSecondary' => 'Secondary',
                                'lightOnSecondary' => 'On Secondary',
                                'lightOutline' => 'Outline',
                                'lightOutlineStrong' => 'Outline Strong',
                            ] as $prop => $label)
                                <div class="flex items-center gap-3">
                                    <input
                                        type="color"
                                        wire:model.live.debounce.200ms="{{ $prop }}"
                                        class="h-9 w-12 shrink-0 cursor-pointer rounded border border-outline bg-transparent dark:border-outline-dark"
                                    />
                                    <div class="flex-1">
                                        <x-input-label :value="$label" />
                                        <x-input
                                            type="text"
                                            wire:model.live.debounce.300ms="{{ $prop }}"
                                            class="mt-1 font-mono text-xs"
                                            maxlength="7"
                                            placeholder="#000000"
                                        />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>

                    <!-- Dark Mode Colors -->
                    <x-card>
                        <x-slot name="header">
                            <x-typography.heading accent>{{ __('Dark Mode') }}</x-typography.heading>
                        </x-slot>

                        <div class="flex flex-col gap-4">
                            @foreach ([
                                'darkSurface' => 'Surface',
                                'darkSurfaceAlt' => 'Surface Alt',
                                'darkOnSurface' => 'On Surface',
                                'darkOnSurfaceStrong' => 'On Surface Strong',
                                'darkPrimary' => 'Primary',
                                'darkOnPrimary' => 'On Primary',
                                'darkSecondary' => 'Secondary',
                                'darkOnSecondary' => 'On Secondary',
                                'darkOutline' => 'Outline',
                                'darkOutlineStrong' => 'Outline Strong',
                            ] as $prop => $label)
                                <div class="flex items-center gap-3">
                                    <input
                                        type="color"
                                        wire:model.live.debounce.200ms="{{ $prop }}"
                                        class="h-9 w-12 shrink-0 cursor-pointer rounded border border-outline bg-transparent dark:border-outline-dark"
                                    />
                                    <div class="flex-1">
                                        <x-input-label :value="$label" />
                                        <x-input
                                            type="text"
                                            wire:model.live.debounce.300ms="{{ $prop }}"
                                            class="mt-1 font-mono text-xs"
                                            maxlength="7"
                                            placeholder="#000000"
                                        />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                </div>

                <!-- Semantic Colors -->
                <x-card>
                    <x-slot name="header">
                        <x-typography.heading accent>{{ __('Semantic Colors') }}</x-typography.heading>
                    </x-slot>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ([
                            'semanticInfo' => 'Info',
                            'semanticOnInfo' => 'On Info',
                            'semanticSuccess' => 'Success',
                            'semanticOnSuccess' => 'On Success',
                            'semanticWarning' => 'Warning',
                            'semanticOnWarning' => 'On Warning',
                            'semanticDanger' => 'Danger',
                            'semanticOnDanger' => 'On Danger',
                        ] as $prop => $label)
                            <div class="flex items-center gap-3">
                                <input
                                    type="color"
                                    wire:model.live.debounce.200ms="{{ $prop }}"
                                    class="h-9 w-12 shrink-0 cursor-pointer rounded border border-outline bg-transparent dark:border-outline-dark"
                                />
                                <div class="flex-1">
                                    <x-input-label :value="$label" />
                                    <x-input
                                        type="text"
                                        wire:model.live.debounce.300ms="{{ $prop }}"
                                        class="mt-1 font-mono text-xs"
                                        maxlength="7"
                                        placeholder="#000000"
                                    />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>

                <div class="flex items-center gap-2">
                    <x-button wire:click="saveTheme">{{ __('Save Theme') }}</x-button>
                    <x-button variant="outline" wire:click="resetToDefault">{{ __('Reset to Default') }}</x-button>
                </div>
            </div>
        </x-tab-panel>

        <!-- Typography & Effects Tab -->
        <x-tab-panel name="typography">
            <div class="flex flex-col gap-6">
                <x-card>
                    <x-slot name="header">
                        <x-typography.heading accent>{{ __('Typography & Effects') }}</x-typography.heading>
                    </x-slot>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div>
                            <x-input-label value="{{ __('Font Family') }}" for="font-family" />
                            <x-select id="font-family" wire:model.live="fontFamily" class="mt-1">
                                @foreach ($fontOptions as $font)
                                    <option value="{{ $font }}">{{ $font }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
                            <x-input-label value="{{ __('Border Radius') }}" for="border-radius" />
                            <x-select id="border-radius" wire:model.live="radius" class="mt-1">
                                @foreach ($radiusOptions as $label => $value)
                                    <option value="{{ $value }}">{{ ucfirst($label) }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
                            <x-input-label value="{{ __('Animation Speed') }}" for="animation-speed" />
                            <x-select id="animation-speed" wire:model.live="speed" class="mt-1">
                                @foreach ($speedOptions as $label => $value)
                                    <option value="{{ $value }}">{{ ucfirst($label) }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </x-card>

                <!-- Live Preview Area -->
                <x-card>
                    <x-slot name="header">
                        <x-typography.heading accent>{{ __('Live Preview') }}</x-typography.heading>
                    </x-slot>

                    <div class="flex flex-wrap items-center gap-4">
                        <x-button>{{ __('Primary Button') }}</x-button>
                        <x-button variant="secondary">{{ __('Secondary') }}</x-button>
                        <x-button variant="outline">{{ __('Outline') }}</x-button>
                        <x-button variant="ghost">{{ __('Ghost') }}</x-button>

                        <x-badge>{{ __('Default') }}</x-badge>
                        <x-badge variant="info">{{ __('Info') }}</x-badge>
                        <x-badge variant="success">{{ __('Success') }}</x-badge>
                        <x-badge variant="warning">{{ __('Warning') }}</x-badge>
                        <x-badge variant="danger">{{ __('Danger') }}</x-badge>

                        <x-input type="text" placeholder="{{ __('Sample input...') }}" class="max-w-xs" />

                        <x-toggle id="preview-toggle">{{ __('Toggle') }}</x-toggle>
                    </div>
                </x-card>

                <div class="flex items-center gap-2">
                    <x-button wire:click="saveTheme">{{ __('Save Theme') }}</x-button>
                    <x-button variant="outline" wire:click="resetToDefault">{{ __('Reset to Default') }}</x-button>
                </div>
            </div>
        </x-tab-panel>
    </x-tabs>
</div>
