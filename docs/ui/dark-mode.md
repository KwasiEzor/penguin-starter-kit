# Dark Mode

Three theme modes: **Light**, **Dark**, and **System** (follows OS preference).

## How It Works

The theme is managed by three layers:

### 1. CSS Custom Properties

PenguinUI design tokens in `resources/css/app.css` define both light and dark palettes:

```css
@theme {
    /* Light mode */
    --color-surface: var(--color-white);
    --color-on-surface: var(--color-neutral-600);

    /* Dark mode (applied via .dark class) */
    --color-surface-dark: var(--color-neutral-900);
    --color-on-surface-dark: var(--color-neutral-300);
}
```

### 2. ThemeManager JavaScript

In `partials/scripts.blade.php`, the ThemeManager reads from `localStorage` and applies the `dark` class to `<html>`:

```js
// Reads localStorage.theme
// Applies 'dark' class to <html> element
// Listens for OS preference changes in 'system' mode
```

### 3. Appearance Settings

Users pick their preferred theme in **Settings > Appearance** with three options:
- **Light** — always light mode
- **Dark** — always dark mode
- **System** — follows OS preference

## Persistence

The theme persists across sessions via `localStorage.theme`. This ensures the correct theme is applied instantly on page load, avoiding flash-of-unstyled-content (FOUC).

## For Developers

All components automatically support dark mode through PenguinUI's semantic tokens. When building new components, use the design tokens instead of raw colors:

```blade
{{-- Good: uses semantic tokens --}}
<div class="bg-surface text-on-surface border-outline">

{{-- Avoid: raw colors don't adapt to dark mode --}}
<div class="bg-white text-gray-900 border-gray-200">
```
