# Theme Presets

The admin can change the entire application's look and feel from **Admin > Theme**.

## 8 Built-in Presets

| Preset | Description | Font |
|---|---|---|
| **Default** | Clean neutral theme | Instrument Sans |
| **Midnight** | Deep blacks and electric accents | Inter |
| **Ocean** | Fresh blues and breezy greens | Inter |
| **Slate** | Professional and sober | Plus Jakarta Sans |
| **Forest** | Earthy tones with verdant energy | DM Sans |
| **Rose** | Soft and elegant | Outfit |
| **Vintage** | Classic and timeless | Playfair Display |
| **Cyberpunk** | High-tech, low-life vibes | Fira Code |

## What Each Preset Customizes

Each preset configures the following properties:

| Property | Description |
|---|---|
| Surface colors | Background colors for light and dark modes |
| Primary/secondary colors | Brand colors for buttons, links, and accents |
| Semantic colors | Info, success, warning, danger colors |
| Border radius | Corner rounding for cards and containers |
| Button radius | Corner rounding for buttons specifically |
| Transition speed | Animation speed for hover and state changes |
| Easing | Animation easing curve |
| Shadows | Box shadow depth and spread |
| Font family | Typography via Bunny Fonts |

## Custom Themes

Beyond presets, the admin can individually customize any color, radius, shadow, or font value. The theme editor provides:

- **Color pickers** for every semantic token in both light and dark modes
- **Live preview** — see changes before applying
- **Instant application** — no build step required

## Available Fonts

10 font families are available via [Bunny Fonts](https://fonts.bunny.net/):

1. Instrument Sans
2. Inter
3. Plus Jakarta Sans
4. DM Sans
5. Outfit
6. Playfair Display
7. Fira Code
8. Source Sans 3
9. Nunito
10. Roboto

## How It Works

The `ThemeService` generates CSS at runtime from database-stored theme overrides. All values are validated and sanitized before output to prevent CSS injection.

```
Admin saves theme → Database → ThemeService → Runtime CSS → Applied to page
```
