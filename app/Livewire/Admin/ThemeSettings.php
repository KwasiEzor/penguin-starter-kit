<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Livewire\Concerns\HasToast;
use App\Services\ThemeService;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Livewire component for managing the application theme.
 *
 * Allows administrators to customize colors, fonts, border radius,
 * and animation speed with live preview and built-in presets.
 */
#[Layout('components.layouts.app')]
final class ThemeSettings extends Component
{
    use HasToast;

    // Preset
    public string $preset = 'default';

    // Light mode colors
    public string $lightSurface = '#ffffff';

    public string $lightSurfaceAlt = '#fafafa';

    public string $lightOnSurface = '#525252';

    public string $lightOnSurfaceStrong = '#171717';

    public string $lightPrimary = '#000000';

    public string $lightOnPrimary = '#e5e5e5';

    public string $lightSecondary = '#262626';

    public string $lightOnSecondary = '#ffffff';

    public string $lightOutline = '#d4d4d4';

    public string $lightOutlineStrong = '#262626';

    // Dark mode colors
    public string $darkSurface = '#0a0a0a';

    public string $darkSurfaceAlt = '#171717';

    public string $darkOnSurface = '#d4d4d4';

    public string $darkOnSurfaceStrong = '#ffffff';

    public string $darkPrimary = '#ffffff';

    public string $darkOnPrimary = '#000000';

    public string $darkSecondary = '#d4d4d4';

    public string $darkOnSecondary = '#000000';

    public string $darkOutline = '#404040';

    public string $darkOutlineStrong = '#d4d4d4';

    // Semantic colors
    public string $semanticInfo = '#0ea5e9';

    public string $semanticOnInfo = '#ffffff';

    public string $semanticSuccess = '#22c55e';

    public string $semanticOnSuccess = '#ffffff';

    public string $semanticWarning = '#f59e0b';

    public string $semanticOnWarning = '#ffffff';

    public string $semanticDanger = '#ef4444';

    public string $semanticOnDanger = '#ffffff';

    // Typography & Effects
    public string $fontFamily = 'Instrument Sans';

    public string $radius = '0.5rem';

    public string $buttonRadius = '0.375rem';

    public string $speed = '0.15s';

    public string $easing = 'cubic-bezier(0.4, 0, 0.2, 1)';

    public string $shadow = 'premium';

    /**
     * Initialize the component with current theme values.
     */
    public function mount(ThemeService $themeService): void
    {
        $this->preset = $themeService->getPreset();
        $this->fontFamily = $themeService->getFontFamily();

        $overrides = $themeService->getOverrides();

        if ($overrides !== null) {
            $this->fillFromOverrides($overrides);
        }
    }

    /**
     * Apply a preset theme, populating all color properties.
     */
    public function applyPreset(string $name): void
    {
        $themeService = app(ThemeService::class);
        $presets = $themeService->getPresets();

        if (! isset($presets[$name])) {
            return;
        }

        $preset = $presets[$name];
        $this->preset = $name;
        $this->fontFamily = $preset['font'];
        $this->radius = $preset['radius'];
        $this->buttonRadius = $preset['button-radius'] ?? $preset['radius'];
        $this->speed = $preset['transition-duration'];
        $this->easing = $preset['transition-easing'] ?? 'cubic-bezier(0.4, 0, 0.2, 1)';
        $this->shadow = $preset['shadow'] ?? 'premium';

        $this->fillFromOverrides($preset['colors']);
    }

    /**
     * Save the current theme configuration.
     */
    public function saveTheme(): void
    {
        $colorProperties = [
            'lightSurface', 'lightSurfaceAlt', 'lightOnSurface', 'lightOnSurfaceStrong',
            'lightPrimary', 'lightOnPrimary', 'lightSecondary', 'lightOnSecondary',
            'lightOutline', 'lightOutlineStrong',
            'darkSurface', 'darkSurfaceAlt', 'darkOnSurface', 'darkOnSurfaceStrong',
            'darkPrimary', 'darkOnPrimary', 'darkSecondary', 'darkOnSecondary',
            'darkOutline', 'darkOutlineStrong',
            'semanticInfo', 'semanticOnInfo', 'semanticSuccess', 'semanticOnSuccess',
            'semanticWarning', 'semanticOnWarning', 'semanticDanger', 'semanticOnDanger',
        ];

        foreach ($colorProperties as $prop) {
            if (! preg_match('/^#[0-9a-fA-F]{6}$/', $this->{$prop})) {
                $this->addError($prop, 'Invalid hex color format.');

                return;
            }
        }

        $overrides = [
            'light' => [
                'surface' => $this->lightSurface,
                'surface-alt' => $this->lightSurfaceAlt,
                'on-surface' => $this->lightOnSurface,
                'on-surface-strong' => $this->lightOnSurfaceStrong,
                'primary' => $this->lightPrimary,
                'on-primary' => $this->lightOnPrimary,
                'secondary' => $this->lightSecondary,
                'on-secondary' => $this->lightOnSecondary,
                'outline' => $this->lightOutline,
                'outline-strong' => $this->lightOutlineStrong,
            ],
            'dark' => [
                'surface' => $this->darkSurface,
                'surface-alt' => $this->darkSurfaceAlt,
                'on-surface' => $this->darkOnSurface,
                'on-surface-strong' => $this->darkOnSurfaceStrong,
                'primary' => $this->darkPrimary,
                'on-primary' => $this->darkOnPrimary,
                'secondary' => $this->darkSecondary,
                'on-secondary' => $this->darkOnSecondary,
                'outline' => $this->darkOutline,
                'outline-strong' => $this->darkOutlineStrong,
            ],
            'semantic' => [
                'info' => $this->semanticInfo,
                'on-info' => $this->semanticOnInfo,
                'success' => $this->semanticSuccess,
                'on-success' => $this->semanticOnSuccess,
                'warning' => $this->semanticWarning,
                'on-warning' => $this->semanticOnWarning,
                'danger' => $this->semanticDanger,
                'on-danger' => $this->semanticOnDanger,
            ],
            'radius' => $this->radius,
            'button-radius' => $this->buttonRadius,
            'transition-duration' => $this->speed,
            'transition-easing' => $this->easing,
            'shadow' => $this->shadow,
        ];

        $themeService = app(ThemeService::class);
        $themeService->save($this->preset, $overrides, $this->fontFamily);

        $this->toastSuccess('Theme saved successfully.');
    }

    /**
     * Reset to the default theme and save.
     */
    public function resetToDefault(): void
    {
        $this->applyPreset('default');
        $this->saveTheme();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $themeService = app(ThemeService::class);

        return view('livewire.admin.theme-settings', [
            'presets' => $themeService->getPresets(),
            'fontOptions' => array_keys(config('theme.fonts', [])),
            'radiusOptions' => config('theme.radius', []),
            'speedOptions' => config('theme.speed', []),
            'easingOptions' => config('theme.easing', []),
            'shadowOptions' => config('theme.shadows', []),
        ]);
    }

    /**
     * Populate color properties from an overrides array.
     *
     * @param  array<string, mixed>  $overrides
     */
    private function fillFromOverrides(array $overrides): void
    {
        $lightMap = [
            'surface' => 'lightSurface',
            'surface-alt' => 'lightSurfaceAlt',
            'on-surface' => 'lightOnSurface',
            'on-surface-strong' => 'lightOnSurfaceStrong',
            'primary' => 'lightPrimary',
            'on-primary' => 'lightOnPrimary',
            'secondary' => 'lightSecondary',
            'on-secondary' => 'lightOnSecondary',
            'outline' => 'lightOutline',
            'outline-strong' => 'lightOutlineStrong',
        ];

        $darkMap = [
            'surface' => 'darkSurface',
            'surface-alt' => 'darkSurfaceAlt',
            'on-surface' => 'darkOnSurface',
            'on-surface-strong' => 'darkOnSurfaceStrong',
            'primary' => 'darkPrimary',
            'on-primary' => 'darkOnPrimary',
            'secondary' => 'darkSecondary',
            'on-secondary' => 'darkOnSecondary',
            'outline' => 'darkOutline',
            'outline-strong' => 'darkOutlineStrong',
        ];

        $semanticMap = [
            'info' => 'semanticInfo',
            'on-info' => 'semanticOnInfo',
            'success' => 'semanticSuccess',
            'on-success' => 'semanticOnSuccess',
            'warning' => 'semanticWarning',
            'on-warning' => 'semanticOnWarning',
            'danger' => 'semanticDanger',
            'on-danger' => 'semanticOnDanger',
        ];

        if (isset($overrides['light']) && is_array($overrides['light'])) {
            foreach ($lightMap as $key => $prop) {
                if (isset($overrides['light'][$key])) {
                    $this->{$prop} = $overrides['light'][$key];
                }
            }
        }

        if (isset($overrides['dark']) && is_array($overrides['dark'])) {
            foreach ($darkMap as $key => $prop) {
                if (isset($overrides['dark'][$key])) {
                    $this->{$prop} = $overrides['dark'][$key];
                }
            }
        }

        if (isset($overrides['semantic']) && is_array($overrides['semantic'])) {
            foreach ($semanticMap as $key => $prop) {
                if (isset($overrides['semantic'][$key])) {
                    $this->{$prop} = $overrides['semantic'][$key];
                }
            }
        }

        if (isset($overrides['radius'])) {
            $this->radius = $overrides['radius'];
        }
        if (isset($overrides['button-radius'])) {
            $this->buttonRadius = $overrides['button-radius'];
        }
        if (isset($overrides['transition-duration'])) {
            $this->speed = $overrides['transition-duration'];
        }
        if (isset($overrides['transition-easing'])) {
            $this->easing = $overrides['transition-easing'];
        }
        if (isset($overrides['shadow'])) {
            $this->shadow = $overrides['shadow'];
        }
    }
}
