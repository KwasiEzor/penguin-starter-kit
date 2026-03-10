# PenguinUI Design System

All components use semantic design tokens for consistent theming across light and dark modes. The design system is built entirely with CSS custom properties, making it trivial to rebrand.

## Semantic Tokens

| Token | Purpose |
|---|---|
| `surface` | Primary background |
| `surface-alt` | Alternate/card background |
| `on-surface` | Text on surface |
| `on-surface-strong` | Bold/heading text on surface |
| `primary` | Primary brand color |
| `on-primary` | Text on primary |
| `secondary` | Secondary brand color |
| `on-secondary` | Text on secondary |
| `outline` | Border color |
| `outline-strong` | Active/focused border |
| `info` | Informational color |
| `success` | Success color |
| `warning` | Warning color |
| `danger` | Danger/error color |

## How It Works

1. **CSS custom properties** define the color palette in `resources/css/app.css`
2. **Blade components** reference these tokens (e.g., `bg-surface`, `text-on-surface`)
3. **Dark mode** provides alternate values automatically
4. **Admin theme settings** override tokens at runtime via the `ThemeService`

## Customizing

### Admin Panel

Go to **Admin > Theme** to customize colors, fonts, border radius, shadows, and transitions with live preview.

### CSS Custom Properties

Edit `resources/css/app.css`:

```css
@theme {
    --color-primary: var(--color-indigo-600);
    --color-on-primary: var(--color-white);
    --color-surface: var(--color-white);
    --color-on-surface: var(--color-neutral-600);
}
```

## Fonts

10 font families are available via Bunny Fonts, configurable from the admin panel:

- Instrument Sans (default)
- Inter
- Plus Jakarta Sans
- DM Sans
- Outfit
- Playfair Display
- Fira Code
- And more...
