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
            root.setProperty('--radius-button', $wire.buttonRadius)
            root.setProperty('--default-transition-duration', $wire.speed)
            root.setProperty('--default-transition-timing-function', $wire.easing)
            root.setProperty('--shadow-premium', $wire.shadow)

            // Font
            const fontFamily = $wire.fontFamily
            const fontStack = `'${fontFamily}', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'`
            root.setProperty('--font-sans', fontStack)
            root.setProperty('--font-sans-override', fontStack)
        },
    }"
    x-effect="applyPreview()"
    class="flex flex-col gap-6"
>
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <x-breadcrumbs class="mb-2">
                <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
                <x-breadcrumb-item :active="true">{{ __('Theme') }}</x-breadcrumb-item>
            </x-breadcrumbs>
            <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
                {{ __('Theme Customization') }}
            </h1>
            <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium mt-1">
                {{ __('Create a unique visual identity for your application with live preview.') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="outline" wire:click="resetToDefault">{{ __('Reset') }}</x-button>
            <x-button wire:click="saveTheme" class="shadow-lg shadow-primary/20">
                <x-icons.check variant="outline" size="sm" class="mr-1" />
                {{ __('Save Changes') }}
            </x-button>
        </div>
    </div>

    <x-tabs active="presets">
        <x-slot name="tabs">
            <x-tab name="presets">
                <div class="flex items-center gap-2">
                    <x-icons.sparkles variant="outline" size="xs" />
                    {{ __('Presets') }}
                </div>
            </x-tab>
            <x-tab name="colors">
                <div class="flex items-center gap-2">
                    <x-icons.swatch variant="outline" size="xs" />
                    {{ __('Colors') }}
                </div>
            </x-tab>
            <x-tab name="typography">
                <div class="flex items-center gap-2">
                    <x-icons.type variant="outline" size="xs" />
                    {{ __('Typography & Effects') }}
                </div>
            </x-tab>
        </x-slot>

        <!-- Presets Tab -->
        <x-tab-panel name="presets">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($presets as $key => $p)
                    <button
                        type="button"
                        wire:click="applyPreset('{{ $key }}')"
                        @class([
                            'group relative flex flex-col overflow-hidden rounded-2xl border transition-all duration-300',
                            'border-primary bg-primary/5 ring-2 ring-primary/20 dark:border-primary-dark dark:bg-primary-dark/5 dark:ring-primary-dark/20' => $preset === $key,
                            'border-outline bg-surface hover:border-outline-strong dark:border-outline-dark dark:bg-surface-dark dark:hover:border-outline-dark-strong shadow-sm hover:shadow-md' => $preset !== $key,
                        ])
                    >
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-base font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ $p['name'] }}</span>
                                @if($preset === $key)
                                    <x-icons.check-circle variant="solid" size="sm" class="text-primary dark:text-primary-dark" />
                                @endif
                            </div>
                            <p class="text-xs text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed mb-4">
                                {{ $p['description'] }}
                            </p>
                            
                            <!-- Color Swatches -->
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] uppercase tracking-wider font-bold text-on-surface/40 w-10">Light</span>
                                    <div class="flex -space-x-1.5">
                                        @foreach(['primary', 'secondary', 'surface', 'surface-alt'] as $c)
                                            <span class="size-6 rounded-full border border-white dark:border-surface-dark shadow-sm" style="background-color: {{ $p['colors']['light'][$c] }}"></span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] uppercase tracking-wider font-bold text-on-surface/40 w-10">Dark</span>
                                    <div class="flex -space-x-1.5">
                                        @foreach(['primary', 'secondary', 'surface', 'surface-alt'] as $c)
                                            <span class="size-6 rounded-full border border-white dark:border-surface-dark shadow-sm" style="background-color: {{ $p['colors']['dark'][$c] }}"></span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Details Badge -->
                        <div class="mt-auto border-t border-outline/50 bg-black/5 p-3 dark:border-outline-dark/50 dark:bg-white/5">
                            <div class="flex items-center justify-between text-[10px] font-bold text-on-surface/50 uppercase tracking-widest">
                                <span>{{ $p['font'] }}</span>
                                <span>{{ $p['radius'] }} Radius</span>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-tab-panel>

        <!-- Colors Tab -->
        <x-tab-panel name="colors">
            <div class="flex flex-col gap-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <!-- Light Mode Colors -->
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-2 px-1">
                            <x-icons.sun variant="outline" size="sm" class="text-warning" />
                            <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Light Mode Palette') }}</h3>
                        </div>
                        <x-card padding="false">
                            <div class="divide-y divide-outline dark:divide-outline-dark">
                                @foreach ([
                                    'lightSurface' => ['label' => 'Surface', 'desc' => 'Main background color'],
                                    'lightSurfaceAlt' => ['label' => 'Surface Alt', 'desc' => 'Secondary background'],
                                    'lightOnSurface' => ['label' => 'On Surface', 'desc' => 'Regular text color'],
                                    'lightOnSurfaceStrong' => ['label' => 'On Surface Strong', 'desc' => 'Headings and bold text'],
                                    'lightPrimary' => ['label' => 'Primary', 'desc' => 'Main brand color'],
                                    'lightOnPrimary' => ['label' => 'On Primary', 'desc' => 'Text on primary color'],
                                    'lightSecondary' => ['label' => 'Secondary', 'desc' => 'Accent color'],
                                    'lightOnSecondary' => ['label' => 'On Secondary', 'desc' => 'Text on secondary'],
                                    'lightOutline' => ['label' => 'Outline', 'desc' => 'Regular borders'],
                                    'lightOutlineStrong' => ['label' => 'Outline Strong', 'desc' => 'Emphasis borders'],
                                ] as $prop => $info)
                                    <div class="flex items-center gap-4 p-4 transition-colors hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50">
                                        <div class="relative size-12 shrink-0 overflow-hidden rounded-xl border border-outline dark:border-outline-dark shadow-sm">
                                            <input
                                                type="color"
                                                wire:model.live.debounce.150ms="{{ $prop }}"
                                                class="absolute inset-0 size-full cursor-pointer border-none p-0 scale-150"
                                            />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <x-input-label :value="$info['label']" class="text-sm font-bold" />
                                                <span class="text-[10px] font-mono font-bold text-on-surface/40 uppercase tracking-wider">{{ $this->{$prop} }}</span>
                                            </div>
                                            <p class="text-xs text-on-surface/50">{{ $info['desc'] }}</p>
                                        </div>
                                        <x-input
                                            type="text"
                                            wire:model.live.debounce.300ms="{{ $prop }}"
                                            class="w-24 font-mono text-xs text-center"
                                            maxlength="7"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </x-card>
                    </div>

                    <!-- Dark Mode Colors -->
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-2 px-1">
                            <x-icons.moon variant="outline" size="sm" class="text-primary" />
                            <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Dark Mode Palette') }}</h3>
                        </div>
                        <x-card padding="false">
                            <div class="divide-y divide-outline dark:divide-outline-dark">
                                @foreach ([
                                    'darkSurface' => ['label' => 'Surface', 'desc' => 'Main background color'],
                                    'darkSurfaceAlt' => ['label' => 'Surface Alt', 'desc' => 'Secondary background'],
                                    'darkOnSurface' => ['label' => 'On Surface', 'desc' => 'Regular text color'],
                                    'darkOnSurfaceStrong' => ['label' => 'On Surface Strong', 'desc' => 'Headings and bold text'],
                                    'darkPrimary' => ['label' => 'Primary', 'desc' => 'Main brand color'],
                                    'darkOnPrimary' => ['label' => 'On Primary', 'desc' => 'Text on primary color'],
                                    'darkSecondary' => ['label' => 'Secondary', 'desc' => 'Accent color'],
                                    'darkOnSecondary' => ['label' => 'On Secondary', 'desc' => 'Text on secondary'],
                                    'darkOutline' => ['label' => 'Outline', 'desc' => 'Regular borders'],
                                    'darkOutlineStrong' => ['label' => 'Outline Strong', 'desc' => 'Emphasis borders'],
                                ] as $prop => $info)
                                    <div class="flex items-center gap-4 p-4 transition-colors hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50">
                                        <div class="relative size-12 shrink-0 overflow-hidden rounded-xl border border-outline dark:border-outline-dark shadow-sm">
                                            <input
                                                type="color"
                                                wire:model.live.debounce.150ms="{{ $prop }}"
                                                class="absolute inset-0 size-full cursor-pointer border-none p-0 scale-150"
                                            />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <x-input-label :value="$info['label']" class="text-sm font-bold" />
                                                <span class="text-[10px] font-mono font-bold text-on-surface/40 uppercase tracking-wider">{{ $this->{$prop} }}</span>
                                            </div>
                                            <p class="text-xs text-on-surface/50">{{ $info['desc'] }}</p>
                                        </div>
                                        <x-input
                                            type="text"
                                            wire:model.live.debounce.300ms="{{ $prop }}"
                                            class="w-24 font-mono text-xs text-center"
                                            maxlength="7"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </x-card>
                    </div>
                </div>

                <!-- Semantic Colors -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 px-1">
                        <x-icons.shield variant="outline" size="sm" class="text-success" />
                        <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Semantic & Feedback Colors') }}</h3>
                    </div>
                    <x-card padding="false">
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-outline dark:divide-outline-dark">
                            @foreach ([
                                'semanticInfo' => 'Info',
                                'semanticSuccess' => 'Success',
                                'semanticWarning' => 'Warning',
                                'semanticDanger' => 'Danger',
                            ] as $prop => $label)
                                <div class="flex items-center gap-4 p-4 transition-colors hover:bg-surface-alt/50 dark:hover:bg-surface-dark/50 border-b border-outline dark:border-outline-dark md:last:border-b-0">
                                    <div class="relative size-12 shrink-0 overflow-hidden rounded-xl border border-outline dark:border-outline-dark shadow-sm">
                                        <input
                                            type="color"
                                            wire:model.live.debounce.150ms="{{ $prop }}"
                                            class="absolute inset-0 size-full cursor-pointer border-none p-0 scale-150"
                                        />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <x-input-label :value="$label" class="text-sm font-bold" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <x-input
                                                type="text"
                                                wire:model.live.debounce.300ms="{{ $prop }}"
                                                class="w-24 font-mono text-xs"
                                                maxlength="7"
                                            />
                                            <span class="text-[10px] font-mono font-bold text-on-surface/40 uppercase tracking-wider">{{ $this->{$prop} }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- "On" color -->
                                    @php $onProp = $prop . 'On' . (str_ends_with($prop, 'y') ? 'y' : '') . (str_ends_with($prop, 's') ? 's' : '') . (str_ends_with($prop, 'o') ? 'o' : ''); 
                                         // Simplify property name generation logic for sematic on colors
                                         $onProp = str_replace('semantic', 'semanticOn', $prop);
                                    @endphp
                                    <div class="flex flex-col gap-1 items-end">
                                        <x-input-label :value="'On ' . $label" class="text-[10px] font-bold uppercase tracking-widest text-on-surface/40" />
                                        <div class="relative size-8 overflow-hidden rounded-lg border border-outline dark:border-outline-dark shadow-sm">
                                            <input
                                                type="color"
                                                wire:model.live.debounce.150ms="{{ $onProp }}"
                                                class="absolute inset-0 size-full cursor-pointer border-none p-0 scale-150"
                                            />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                </div>
            </div>
        </x-tab-panel>

        <!-- Typography & Effects Tab -->
        <x-tab-panel name="typography">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div class="flex flex-col gap-6">
                    <x-card>
                        <x-slot name="header">
                            <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Typography') }}</h3>
                        </x-slot>

                        <div class="flex flex-col gap-6">
                            <div>
                                <x-input-label value="{{ __('Font Family') }}" for="font-family" />
                                <p class="text-xs text-on-surface/60 mb-3">{{ __('Choose the primary typeface for your application.') }}</p>
                                <x-select id="font-family" wire:model.live="fontFamily" class="w-full">
                                    @foreach ($fontOptions as $font)
                                        <option value="{{ $font }}">{{ $font }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            
                            <div class="rounded-xl bg-surface-alt/50 p-6 border border-outline dark:border-outline-dark dark:bg-surface-dark/50">
                                <h4 class="text-[10px] uppercase tracking-[0.2em] font-black text-on-surface/40 mb-4">{{ __('Typeface Preview') }}</h4>
                                <div class="space-y-4">
                                    <p class="text-2xl font-bold leading-tight" style="font-family: var(--font-sans)">{{ __('The quick brown fox jumps over the lazy dog.') }}</p>
                                    <p class="text-sm opacity-70 leading-relaxed" style="font-family: var(--font-sans)">
                                        {{ __('Grumpy wizards make toxic brew for the evil Queen and Jack.') }}
                                    </p>
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded uppercase tracking-wider">Bold 700</span>
                                        <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-medium rounded uppercase tracking-wider">Medium 500</span>
                                        <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-normal rounded uppercase tracking-wider">Regular 400</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>

                    <x-card>
                        <x-slot name="header">
                            <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Layout & Shape') }}</h3>
                        </x-slot>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label value="{{ __('App Radius') }}" for="border-radius" />
                                <x-select id="border-radius" wire:model.live="radius" class="mt-1 w-full">
                                    @foreach ($radiusOptions as $label => $value)
                                        <option value="{{ $value }}">{{ ucfirst($label) }} ({{ $value }})</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div>
                                <x-input-label value="{{ __('Button Radius') }}" for="button-radius" />
                                <x-select id="button-radius" wire:model.live="buttonRadius" class="mt-1 w-full">
                                    @foreach ($radiusOptions as $label => $value)
                                        <option value="{{ $value }}">{{ ucfirst($label) }} ({{ $value }})</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                    </x-card>
                </div>

                <div class="flex flex-col gap-6">
                    <x-card>
                        <x-slot name="header">
                            <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Motion & Depth') }}</h3>
                        </x-slot>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label value="{{ __('Animation Speed') }}" for="animation-speed" />
                                    <x-select id="animation-speed" wire:model.live="speed" class="mt-1 w-full">
                                        @foreach ($speedOptions as $label => $value)
                                            <option value="{{ $value }}">{{ ucfirst($label) }} ({{ $value }})</option>
                                        @endforeach
                                    </x-select>
                                </div>

                                <div>
                                    <x-input-label value="{{ __('Easing Style') }}" for="animation-easing" />
                                    <x-select id="animation-easing" wire:model.live="easing" class="mt-1 w-full">
                                        @foreach ($easingOptions as $label => $value)
                                            <option value="{{ $value }}">{{ ucfirst($label) }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>

                            <div>
                                <x-input-label value="{{ __('Shadow Style') }}" for="shadow-style" />
                                <x-select id="shadow-style" wire:model.live="shadow" class="mt-1 w-full">
                                    @foreach ($shadowOptions as $label => $value)
                                        <option value="{{ $value }}">{{ ucfirst($label) }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                    </x-card>

                    <!-- Enhanced Live Preview Area -->
                    <x-card class="flex-1">
                        <x-slot name="header">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Live UI Preview') }}</h3>
                                <div class="flex items-center gap-1">
                                    <div class="size-2 rounded-full bg-success animate-pulse"></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-success">Live</span>
                                </div>
                            </div>
                        </x-slot>

                        <div class="flex flex-col gap-8 p-4 bg-surface-alt/30 dark:bg-surface-dark/30 rounded-2xl border border-dashed border-outline dark:border-outline-dark">
                            <div class="flex flex-wrap items-center gap-4">
                                <x-button class="shadow-premium">{{ __('Primary') }}</x-button>
                                <x-button variant="secondary" class="shadow-premium">{{ __('Secondary') }}</x-button>
                                <x-button variant="outline">{{ __('Outline') }}</x-button>
                                <x-button variant="ghost">{{ __('Ghost') }}</x-button>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <x-badge variant="info">{{ __('Info') }}</x-badge>
                                <x-badge variant="success">{{ __('Success') }}</x-badge>
                                <x-badge variant="warning">{{ __('Warning') }}</x-badge>
                                <x-badge variant="danger">{{ __('Danger') }}</x-badge>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <x-input-label value="Sample Input" />
                                    <x-input type="text" placeholder="Type something..." class="w-full" />
                                </div>
                                <div class="flex items-end pb-1">
                                    <x-toggle id="preview-toggle-2">{{ __('Toggle Switch') }}</x-toggle>
                                </div>
                            </div>
                            
                            <div class="p-4 rounded-radius border border-outline dark:border-outline-dark bg-surface dark:bg-surface-dark shadow-premium">
                                <h5 class="font-bold mb-1">Card Component</h5>
                                <p class="text-xs opacity-60 leading-relaxed">This card demonstrates the current border radius and shadow settings in real-time.</p>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </x-tab-panel>
    </x-tabs>
</div>
