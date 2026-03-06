<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

final class ThemeService
{
    /**
     * Get the stored theme overrides array, or null if none set.
     *
     * @return array<string, mixed>|null
     */
    public function getOverrides(): ?array
    {
        $json = Setting::get('theme.overrides');

        if ($json === null) {
            return null;
        }

        /** @var array<string, mixed>|null $decoded */
        $decoded = json_decode($json, true);

        return $decoded;
    }

    /**
     * Get the current preset name.
     */
    public function getPreset(): string
    {
        return (string) Setting::get('theme.preset', 'default');
    }

    /**
     * Get the current font family name.
     */
    public function getFontFamily(): string
    {
        return (string) Setting::get('theme.font_family', 'Instrument Sans');
    }

    /**
     * Get all available preset definitions.
     *
     * @return array<string, array<string, mixed>>
     */
    public function getPresets(): array
    {
        return [
            'default' => [
                'name' => 'Default',
                'description' => 'Clean neutral theme',
                'colors' => [
                    'light' => [
                        'surface' => '#ffffff',
                        'surface-alt' => '#fafafa',
                        'on-surface' => '#525252',
                        'on-surface-strong' => '#171717',
                        'primary' => '#000000',
                        'on-primary' => '#e5e5e5',
                        'secondary' => '#262626',
                        'on-secondary' => '#ffffff',
                        'outline' => '#d4d4d4',
                        'outline-strong' => '#262626',
                    ],
                    'dark' => [
                        'surface' => '#0a0a0a',
                        'surface-alt' => '#171717',
                        'on-surface' => '#d4d4d4',
                        'on-surface-strong' => '#ffffff',
                        'primary' => '#ffffff',
                        'on-primary' => '#000000',
                        'secondary' => '#d4d4d4',
                        'on-secondary' => '#000000',
                        'outline' => '#404040',
                        'outline-strong' => '#d4d4d4',
                    ],
                    'semantic' => [
                        'info' => '#0ea5e9',
                        'on-info' => '#ffffff',
                        'success' => '#22c55e',
                        'on-success' => '#ffffff',
                        'warning' => '#f59e0b',
                        'on-warning' => '#ffffff',
                        'danger' => '#ef4444',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0.5rem',
                'transition-duration' => '0.15s',
                'font' => 'Instrument Sans',
            ],
            'ocean' => [
                'name' => 'Ocean',
                'description' => 'Cool blue tones',
                'colors' => [
                    'light' => [
                        'surface' => '#f0f9ff',
                        'surface-alt' => '#e0f2fe',
                        'on-surface' => '#475569',
                        'on-surface-strong' => '#0c4a6e',
                        'primary' => '#0369a1',
                        'on-primary' => '#f0f9ff',
                        'secondary' => '#0284c7',
                        'on-secondary' => '#ffffff',
                        'outline' => '#bae6fd',
                        'outline-strong' => '#0369a1',
                    ],
                    'dark' => [
                        'surface' => '#082f49',
                        'surface-alt' => '#0c4a6e',
                        'on-surface' => '#7dd3fc',
                        'on-surface-strong' => '#e0f2fe',
                        'primary' => '#38bdf8',
                        'on-primary' => '#082f49',
                        'secondary' => '#7dd3fc',
                        'on-secondary' => '#082f49',
                        'outline' => '#075985',
                        'outline-strong' => '#7dd3fc',
                    ],
                    'semantic' => [
                        'info' => '#0ea5e9',
                        'on-info' => '#ffffff',
                        'success' => '#22c55e',
                        'on-success' => '#ffffff',
                        'warning' => '#f59e0b',
                        'on-warning' => '#ffffff',
                        'danger' => '#ef4444',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0.75rem',
                'transition-duration' => '0.15s',
                'font' => 'Inter',
            ],
            'forest' => [
                'name' => 'Forest',
                'description' => 'Natural green palette',
                'colors' => [
                    'light' => [
                        'surface' => '#f0fdf4',
                        'surface-alt' => '#dcfce7',
                        'on-surface' => '#4b5563',
                        'on-surface-strong' => '#14532d',
                        'primary' => '#15803d',
                        'on-primary' => '#f0fdf4',
                        'secondary' => '#166534',
                        'on-secondary' => '#ffffff',
                        'outline' => '#bbf7d0',
                        'outline-strong' => '#15803d',
                    ],
                    'dark' => [
                        'surface' => '#052e16',
                        'surface-alt' => '#14532d',
                        'on-surface' => '#86efac',
                        'on-surface-strong' => '#dcfce7',
                        'primary' => '#4ade80',
                        'on-primary' => '#052e16',
                        'secondary' => '#86efac',
                        'on-secondary' => '#052e16',
                        'outline' => '#166534',
                        'outline-strong' => '#86efac',
                    ],
                    'semantic' => [
                        'info' => '#0ea5e9',
                        'on-info' => '#ffffff',
                        'success' => '#22c55e',
                        'on-success' => '#ffffff',
                        'warning' => '#f59e0b',
                        'on-warning' => '#ffffff',
                        'danger' => '#ef4444',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0.375rem',
                'transition-duration' => '0.15s',
                'font' => 'DM Sans',
            ],
            'sunset' => [
                'name' => 'Sunset',
                'description' => 'Warm orange and amber',
                'colors' => [
                    'light' => [
                        'surface' => '#fffbeb',
                        'surface-alt' => '#fef3c7',
                        'on-surface' => '#78716c',
                        'on-surface-strong' => '#78350f',
                        'primary' => '#c2410c',
                        'on-primary' => '#fffbeb',
                        'secondary' => '#d97706',
                        'on-secondary' => '#ffffff',
                        'outline' => '#fde68a',
                        'outline-strong' => '#c2410c',
                    ],
                    'dark' => [
                        'surface' => '#431407',
                        'surface-alt' => '#7c2d12',
                        'on-surface' => '#fdba74',
                        'on-surface-strong' => '#fed7aa',
                        'primary' => '#fb923c',
                        'on-primary' => '#431407',
                        'secondary' => '#fdba74',
                        'on-secondary' => '#431407',
                        'outline' => '#9a3412',
                        'outline-strong' => '#fdba74',
                    ],
                    'semantic' => [
                        'info' => '#0ea5e9',
                        'on-info' => '#ffffff',
                        'success' => '#22c55e',
                        'on-success' => '#ffffff',
                        'warning' => '#f59e0b',
                        'on-warning' => '#ffffff',
                        'danger' => '#ef4444',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '1rem',
                'transition-duration' => '0.25s',
                'font' => 'Plus Jakarta Sans',
            ],
        ];
    }

    /**
     * Save theme settings to the database.
     *
     * @param  array<string, mixed>  $overrides
     */
    public function save(string $preset, array $overrides, string $fontFamily): void
    {
        Setting::set('theme.preset', $preset, 'theme');
        Setting::set('theme.overrides', json_encode($overrides), 'theme');
        Setting::set('theme.font_family', $fontFamily, 'theme');
    }

    /**
     * Generate CSS string from stored overrides.
     */
    public function generateCss(): string
    {
        $overrides = $this->getOverrides();

        if ($overrides === null) {
            return '';
        }

        $lines = [];

        // Light mode color tokens
        $lightMap = [
            'surface' => '--color-surface',
            'surface-alt' => '--color-surface-alt',
            'on-surface' => '--color-on-surface',
            'on-surface-strong' => '--color-on-surface-strong',
            'primary' => '--color-primary',
            'on-primary' => '--color-on-primary',
            'secondary' => '--color-secondary',
            'on-secondary' => '--color-on-secondary',
            'outline' => '--color-outline',
            'outline-strong' => '--color-outline-strong',
        ];

        // Dark mode color tokens
        $darkMap = [
            'surface' => '--color-surface-dark',
            'surface-alt' => '--color-surface-dark-alt',
            'on-surface' => '--color-on-surface-dark',
            'on-surface-strong' => '--color-on-surface-dark-strong',
            'primary' => '--color-primary-dark',
            'on-primary' => '--color-on-primary-dark',
            'secondary' => '--color-secondary-dark',
            'on-secondary' => '--color-on-secondary-dark',
            'outline' => '--color-outline-dark',
            'outline-strong' => '--color-outline-dark-strong',
        ];

        // Semantic color tokens
        $semanticMap = [
            'info' => '--color-info',
            'on-info' => '--color-on-info',
            'success' => '--color-success',
            'on-success' => '--color-on-success',
            'warning' => '--color-warning',
            'on-warning' => '--color-on-warning',
            'danger' => '--color-danger',
            'on-danger' => '--color-on-danger',
        ];

        if (isset($overrides['light']) && is_array($overrides['light'])) {
            foreach ($lightMap as $key => $cssVar) {
                if (isset($overrides['light'][$key])) {
                    $lines[] = '    '.$cssVar.': '.$overrides['light'][$key].';';
                }
            }
        }

        if (isset($overrides['dark']) && is_array($overrides['dark'])) {
            foreach ($darkMap as $key => $cssVar) {
                if (isset($overrides['dark'][$key])) {
                    $lines[] = '    '.$cssVar.': '.$overrides['dark'][$key].';';
                }
            }
        }

        if (isset($overrides['semantic']) && is_array($overrides['semantic'])) {
            foreach ($semanticMap as $key => $cssVar) {
                if (isset($overrides['semantic'][$key])) {
                    $lines[] = '    '.$cssVar.': '.$overrides['semantic'][$key].';';
                }
            }
        }

        if (isset($overrides['radius'])) {
            $lines[] = '    --radius-radius: '.$overrides['radius'].';';
        }

        if (isset($overrides['transition-duration'])) {
            $lines[] = '    --default-transition-duration: '.$overrides['transition-duration'].';';
        }

        // Font family override
        $fontFamily = $this->getFontFamily();
        if ($fontFamily !== 'Instrument Sans') {
            $lines[] = "    --font-sans: '{$fontFamily}', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';";
        }

        if ($lines === []) {
            return '';
        }

        return ":root {\n".implode("\n", $lines)."\n}";
    }
}
