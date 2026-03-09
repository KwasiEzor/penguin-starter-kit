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

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

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
                'button-radius' => '0.375rem',
                'transition-duration' => '0.15s',
                'transition-easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
                'shadow' => '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02)',
                'font' => 'Instrument Sans',
            ],
            'midnight' => [
                'name' => 'Midnight',
                'description' => 'Deep blacks and electric accents',
                'colors' => [
                    'light' => [
                        'surface' => '#ffffff',
                        'surface-alt' => '#f8fafc',
                        'on-surface' => '#475569',
                        'on-surface-strong' => '#0f172a',
                        'primary' => '#6366f1',
                        'on-primary' => '#ffffff',
                        'secondary' => '#1e293b',
                        'on-secondary' => '#ffffff',
                        'outline' => '#e2e8f0',
                        'outline-strong' => '#6366f1',
                    ],
                    'dark' => [
                        'surface' => '#020617',
                        'surface-alt' => '#0f172a',
                        'on-surface' => '#94a3b8',
                        'on-surface-strong' => '#f8fafc',
                        'primary' => '#818cf8',
                        'on-primary' => '#020617',
                        'secondary' => '#94a3b8',
                        'on-secondary' => '#020617',
                        'outline' => '#1e293b',
                        'outline-strong' => '#818cf8',
                    ],
                    'semantic' => [
                        'info' => '#38bdf8',
                        'on-info' => '#ffffff',
                        'success' => '#4ade80',
                        'on-success' => '#ffffff',
                        'warning' => '#fbbf24',
                        'on-warning' => '#ffffff',
                        'danger' => '#f87171',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0.75rem',
                'button-radius' => '0.5rem',
                'transition-duration' => '0.2s',
                'transition-easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
                'shadow' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
                'font' => 'Inter',
            ],
            'ocean' => [
                'name' => 'Ocean',
                'description' => 'Fresh blues and breezy greens',
                'colors' => [
                    'light' => [
                        'surface' => '#ecfeff',
                        'surface-alt' => '#dbeafe',
                        'on-surface' => '#0f172a',
                        'on-surface-strong' => '#0b0f19',
                        'primary' => '#0369a1',
                        'on-primary' => '#ffffff',
                        'secondary' => '#0ea5e9',
                        'on-secondary' => '#ffffff',
                        'outline' => '#a5f3fc',
                        'outline-strong' => '#22d3ee',
                    ],
                    'dark' => [
                        'surface' => '#0f172a',
                        'surface-alt' => '#1e293b',
                        'on-surface' => '#e0f2fe',
                        'on-surface-strong' => '#ffffff',
                        'primary' => '#38bdf8',
                        'on-primary' => '#0f172a',
                        'secondary' => '#22d3ee',
                        'on-secondary' => '#0f172a',
                        'outline' => '#2563eb',
                        'outline-strong' => '#38bdf8',
                    ],
                    'semantic' => [
                        'info' => '#38bdf8',
                        'on-info' => '#0f172a',
                        'success' => '#34d399',
                        'on-success' => '#083334',
                        'warning' => '#facc15',
                        'on-warning' => '#0f172a',
                        'danger' => '#ef4444',
                        'on-danger' => '#0f172a',
                    ],
                ],
                'radius' => '0.75rem',
                'button-radius' => '0.75rem',
                'transition-duration' => '0.2s',
                'transition-easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
                'shadow' => '0 10px 15px -3px rgba(14, 165, 233, 0.3), 0 4px 6px -2px rgba(2, 6, 23, 0.2)',
                'font' => 'Inter',
            ],
            'slate' => [
                'name' => 'Slate',
                'description' => 'Professional and sober',
                'colors' => [
                    'light' => [
                        'surface' => '#ffffff',
                        'surface-alt' => '#f1f5f9',
                        'on-surface' => '#64748b',
                        'on-surface-strong' => '#334155',
                        'primary' => '#475569',
                        'on-primary' => '#ffffff',
                        'secondary' => '#1e293b',
                        'on-secondary' => '#ffffff',
                        'outline' => '#cbd5e1',
                        'outline-strong' => '#475569',
                    ],
                    'dark' => [
                        'surface' => '#0f172a',
                        'surface-alt' => '#1e293b',
                        'on-surface' => '#94a3b8',
                        'on-surface-strong' => '#f1f5f9',
                        'primary' => '#94a3b8',
                        'on-primary' => '#0f172a',
                        'secondary' => '#64748b',
                        'on-secondary' => '#ffffff',
                        'outline' => '#334155',
                        'outline-strong' => '#94a3b8',
                    ],
                    'semantic' => [
                        'info' => '#0ea5e9',
                        'on-info' => '#ffffff',
                        'success' => '#10b981',
                        'on-success' => '#ffffff',
                        'warning' => '#f59e0b',
                        'on-warning' => '#ffffff',
                        'danger' => '#e11d48',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0.375rem',
                'button-radius' => '0.25rem',
                'transition-duration' => '0.1s',
                'transition-easing' => 'linear',
                'shadow' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'font' => 'Plus Jakarta Sans',
            ],
            'forest' => [
                'name' => 'Forest',
                'description' => 'Earthy tones with verdant energy',
                'colors' => [
                    'light' => [
                        'surface' => '#f0fdf4',
                        'surface-alt' => '#dcfce7',
                        'on-surface' => '#065f46',
                        'on-surface-strong' => '#064e3b',
                        'primary' => '#15803d',
                        'on-primary' => '#ffffff',
                        'secondary' => '#10b981',
                        'on-secondary' => '#064e3b',
                        'outline' => '#bbf7d0',
                        'outline-strong' => '#047857',
                    ],
                    'dark' => [
                        'surface' => '#052e16',
                        'surface-alt' => '#064e3b',
                        'on-surface' => '#bbf7d0',
                        'on-surface-strong' => '#e0f2fe',
                        'primary' => '#15803d',
                        'on-primary' => '#ffffff',
                        'secondary' => '#34d399',
                        'on-secondary' => '#064e3b',
                        'outline' => '#065f46',
                        'outline-strong' => '#22c55e',
                    ],
                    'semantic' => [
                        'info' => '#38bdf8',
                        'on-info' => '#0f172a',
                        'success' => '#22c55e',
                        'on-success' => '#0f172a',
                        'warning' => '#facc15',
                        'on-warning' => '#0f172a',
                        'danger' => '#ef4444',
                        'on-danger' => '#0f172a',
                    ],
                ],
                'radius' => '0.5rem',
                'button-radius' => '0.375rem',
                'transition-duration' => '0.18s',
                'transition-easing' => 'cubic-bezier(0.34, 1.56, 0.64, 1)',
                'shadow' => '0 12px 20px -7px rgba(5, 150, 105, 0.35)',
                'font' => 'DM Sans',
            ],
            'rose' => [
                'name' => 'Rose',
                'description' => 'Soft and elegant',
                'colors' => [
                    'light' => [
                        'surface' => '#fff1f2',
                        'surface-alt' => '#ffe4e6',
                        'on-surface' => '#9f1239',
                        'on-surface-strong' => '#4c0519',
                        'primary' => '#e11d48',
                        'on-primary' => '#ffffff',
                        'secondary' => '#fb7185',
                        'on-secondary' => '#ffffff',
                        'outline' => '#fecdd3',
                        'outline-strong' => '#e11d48',
                    ],
                    'dark' => [
                        'surface' => '#4c0519',
                        'surface-alt' => '#881337',
                        'on-surface' => '#fda4af',
                        'on-surface-strong' => '#fff1f2',
                        'primary' => '#fb7185',
                        'on-primary' => '#4c0519',
                        'secondary' => '#fda4af',
                        'on-secondary' => '#4c0519',
                        'outline' => '#9f1239',
                        'outline-strong' => '#fda4af',
                    ],
                    'semantic' => [
                        'info' => '#38bdf8',
                        'on-info' => '#ffffff',
                        'success' => '#34d399',
                        'on-success' => '#ffffff',
                        'warning' => '#fbbf24',
                        'on-warning' => '#ffffff',
                        'danger' => '#f87171',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '1.5rem',
                'button-radius' => '9999px',
                'transition-duration' => '0.3s',
                'transition-easing' => 'cubic-bezier(0.34, 1.56, 0.64, 1)',
                'shadow' => '0 10px 15px -3px rgba(0, 0, 0, 0.05)',
                'font' => 'Outfit',
            ],
            'vintage' => [
                'name' => 'Vintage',
                'description' => 'Classic and timeless',
                'colors' => [
                    'light' => [
                        'surface' => '#faf9f6',
                        'surface-alt' => '#f2f0e9',
                        'on-surface' => '#444444',
                        'on-surface-strong' => '#1a1a1a',
                        'primary' => '#2c3e50',
                        'on-primary' => '#faf9f6',
                        'secondary' => '#7f8c8d',
                        'on-secondary' => '#ffffff',
                        'outline' => '#dcdcdc',
                        'outline-strong' => '#2c3e50',
                    ],
                    'dark' => [
                        'surface' => '#1a1a1a',
                        'surface-alt' => '#2c2c2c',
                        'on-surface' => '#dcdcdc',
                        'on-surface-strong' => '#faf9f6',
                        'primary' => '#ecf0f1',
                        'on-primary' => '#1a1a1a',
                        'secondary' => '#95a5a6',
                        'on-secondary' => '#1a1a1a',
                        'outline' => '#444444',
                        'outline-strong' => '#ecf0f1',
                    ],
                    'semantic' => [
                        'info' => '#3498db',
                        'on-info' => '#ffffff',
                        'success' => '#27ae60',
                        'on-success' => '#ffffff',
                        'warning' => '#f1c40f',
                        'on-warning' => '#ffffff',
                        'danger' => '#c0392b',
                        'on-danger' => '#ffffff',
                    ],
                ],
                'radius' => '0',
                'button-radius' => '0',
                'transition-duration' => '0.15s',
                'transition-easing' => 'ease',
                'shadow' => 'none',
                'font' => 'Playfair Display',
            ],
            'cyberpunk' => [
                'name' => 'Cyberpunk',
                'description' => 'High-tech, low-life vibes',
                'colors' => [
                    'light' => [
                        'surface' => '#fef08a',
                        'surface-alt' => '#fde047',
                        'on-surface' => '#1c1917',
                        'on-surface-strong' => '#000000',
                        'primary' => '#d946ef',
                        'on-primary' => '#000000',
                        'secondary' => '#06b6d4',
                        'on-secondary' => '#000000',
                        'outline' => '#1c1917',
                        'outline-strong' => '#d946ef',
                    ],
                    'dark' => [
                        'surface' => '#0c0a09',
                        'surface-alt' => '#1c1917',
                        'on-surface' => '#fde047',
                        'on-surface-strong' => '#facc15',
                        'primary' => '#d946ef',
                        'on-primary' => '#000000',
                        'secondary' => '#06b6d4',
                        'on-secondary' => '#000000',
                        'outline' => '#d946ef',
                        'outline-strong' => '#06b6d4',
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
                'radius' => '0',
                'button-radius' => '0',
                'transition-duration' => '0.05s',
                'transition-easing' => 'linear',
                'shadow' => 'none',
                'font' => 'Fira Code',
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
     * Validate a hex color string.
     */
    private function isValidHexColor(string $value): bool
    {
        return (bool) preg_match('/^#[0-9a-fA-F]{3,8}$/', $value);
    }

    /**
     * Sanitize a font family name by stripping characters that could break CSS.
     */
    private function sanitizeFontFamily(string $value): string
    {
        return preg_replace('/[{};]/', '', $value) ?? $value;
    }

    /**
     * Validate a CSS numeric value (e.g., "0.5rem", "0.15s", "9999px").
     */
    private function isValidCssNumericValue(string $value): bool
    {
        return (bool) preg_match('/^[0-9]+(\.[0-9]+)?(rem|em|px|s|ms|%)$/', $value);
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

        // Color Maps
        $colorMaps = [
            'light' => [
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
            ],
            'dark' => [
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
            ],
            'semantic' => [
                'info' => '--color-info',
                'on-info' => '--color-on-info',
                'success' => '--color-success',
                'on-success' => '--color-on-success',
                'warning' => '--color-warning',
                'on-warning' => '--color-on-warning',
                'danger' => '--color-danger',
                'on-danger' => '--color-on-danger',
            ],
        ];

        foreach ($colorMaps as $mode => $map) {
            if (isset($overrides[$mode]) && is_array($overrides[$mode])) {
                foreach ($map as $key => $cssVar) {
                    if (isset($overrides[$mode][$key]) && is_string($overrides[$mode][$key]) && $this->isValidHexColor($overrides[$mode][$key])) {
                        $lines[] = '    '.$cssVar.': '.$overrides[$mode][$key].';';
                    }
                }
            }
        }

        // Effects - validate numeric/safe values before outputting
        if (isset($overrides['radius']) && is_string($overrides['radius']) && $this->isValidCssNumericValue($overrides['radius'])) {
            $lines[] = '    --radius-radius: '.$overrides['radius'].';';
        }
        if (isset($overrides['button-radius']) && is_string($overrides['button-radius']) && ($this->isValidCssNumericValue($overrides['button-radius']) || $overrides['button-radius'] === '9999px')) {
            $lines[] = '    --radius-button: '.$overrides['button-radius'].';';
        }
        if (isset($overrides['transition-duration']) && is_string($overrides['transition-duration']) && $this->isValidCssNumericValue($overrides['transition-duration'])) {
            $lines[] = '    --default-transition-duration: '.$overrides['transition-duration'].';';
        }
        if (isset($overrides['transition-easing']) && is_string($overrides['transition-easing']) && preg_match('/^[a-z0-9\-(),.\s]+$/i', $overrides['transition-easing'])) {
            $lines[] = '    --default-transition-timing-function: '.$overrides['transition-easing'].';';
        }
        if (isset($overrides['shadow']) && is_string($overrides['shadow']) && preg_match('/^[a-z0-9\-(),.\s\/#%]+$/i', $overrides['shadow'])) {
            $lines[] = '    --shadow-premium: '.$overrides['shadow'].';';
        }

        // Font family override
        $fontFamily = $this->sanitizeFontFamily($this->getFontFamily());
        if ($fontFamily !== 'Instrument Sans') {
            $stack = "'{$fontFamily}', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'";
            $lines[] = "    --font-sans: {$stack};";
            $lines[] = "    --font-sans-override: {$stack};";
        }

        if ($lines === []) {
            return '';
        }

        return ":root {\n".implode("\n", $lines)."\n}";
    }
}
