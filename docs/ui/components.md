# Components

40+ Blade components built on the PenguinUI design system.

## Form Components

| Component | Description |
|---|---|
| `<x-button>` | 8 variants (`primary`, `secondary`, `outline`, `ghost`, `info`, `danger`, `success`, `warning`), 4 sizes (`xs`, `sm`, `md`, `lg`) |
| `<x-input>` | Text, email, password (with show/hide toggle), and all HTML5 input types |
| `<x-textarea>` | Multi-line text input |
| `<x-select>` | Dropdown select input |
| `<x-checkbox>` | Styled checkbox |
| `<x-toggle>` | Toggle switch |
| `<x-file-upload>` | File upload with preview |
| `<x-trix-input>` | Rich text editor (Trix) |
| `<x-input-label>` | Form labels |
| `<x-input-error>` | Validation error messages |

### Button Examples

```blade
<x-button>Default</x-button>
<x-button variant="secondary">Secondary</x-button>
<x-button variant="outline">Outline</x-button>
<x-button variant="ghost">Ghost</x-button>
<x-button variant="danger">Danger</x-button>
<x-button size="xs">Extra Small</x-button>
<x-button size="lg">Large</x-button>
```

### Input Examples

```blade
<x-input type="text" name="name" label="Name" />
<x-input type="email" name="email" label="Email" />
<x-input type="password" name="password" label="Password" />
```

## Layout Components

| Component | Description |
|---|---|
| `<x-layouts.app>` | Sidebar layout with fixed left navigation |
| `<x-layouts.app-navbar>` | Top navbar layout with responsive hamburger menu |
| `<x-layouts.auth>` | Centered auth layout |
| `<x-layouts.auth.split>` | Split-screen auth layout |
| `<x-layouts.blog>` | Public blog layout |
| `<x-card>` | Content card container |
| `<x-separator>` | Horizontal/vertical divider with optional text |
| `<x-tabs>` | Tabbed navigation container |
| `<x-tab>` | Individual tab trigger |
| `<x-tab-panel>` | Tab content panel |
| `<x-steps>` | Step indicator container |
| `<x-step>` | Individual step |

## Data Display

| Component | Description |
|---|---|
| `<x-table>` | Data table with sortable columns |
| `<x-table-heading>` | Table column header |
| `<x-table-cell>` | Table cell |
| `<x-stat-card>` | Dashboard statistic card |
| `<x-badge>` | Status badges |
| `<x-avatar>` | User avatar with initials fallback |
| `<x-avatar-group>` | Grouped avatars |
| `<x-empty-state>` | Empty state placeholder |
| `<x-skeleton>` | Loading skeleton |
| `<x-loading>` | Loading spinner |
| `<x-progress>` | Progress bar |

## Feedback & Overlay

| Component | Description |
|---|---|
| `<x-modal>` | Modal dialog with trigger slot |
| `<x-toast>` | Toast notifications (success, error, warning, info) with auto-dismiss |
| `<x-alert>` | Alert messages |
| `<x-tooltip>` | Tooltip on hover |
| `<x-dropdown>` | Alpine.js dropdown with keyboard navigation |
| `<x-dropdown-link>` | Dropdown menu item |

### Toast Usage

```php
// In a Livewire component
use App\Livewire\Concerns\HasToast;

class MyComponent extends Component
{
    use HasToast;

    public function save()
    {
        $this->toast('success', 'Settings saved!');
    }
}

// Or from controllers/actions
use App\Support\Toast;

Toast::success('Account created!');
Toast::error('Something went wrong.');
Toast::warning('Please verify your email.');
Toast::info('Check your inbox.');
```

## Navigation

| Component | Description |
|---|---|
| `<x-sidebar-link>` | Sidebar navigation link |
| `<x-nav-link>` | Navbar navigation link |
| `<x-breadcrumbs>` | Breadcrumb navigation |
| `<x-breadcrumb-item>` | Individual breadcrumb |
| `<x-link>` | Styled anchor link |

## Media

| Component | Description |
|---|---|
| `<x-carousel>` | Image/content carousel |
| `<x-carousel-item>` | Carousel slide |
| `<x-accordion>` | Accordion container |
| `<x-accordion-item>` | Accordion panel |
| `<x-image-card>` | Image card with aspect ratio and animation |

## Typography & Branding

| Component | Description |
|---|---|
| `<x-typography.heading>` | Page headings |
| `<x-typography.subheading>` | Secondary text |
| `<x-app-logo>` | Application logo |
| `<x-app-logo-icon>` | Application logo icon |
| `<x-auth-header>` | Auth page header |

## Icon Components

25+ SVG Heroicons and custom icons available as Blade components:

```blade
<x-icons.sparkles class="size-5" />
<x-icons.home class="size-5" />
<x-icons.users class="size-5" />
```

Available icons: `arrow-path`, `arrow-right-start-on-rectangle`, `arrow-up-right`, `bars-3`, `book-open-text`, `check-circle`, `check`, `chevron-down`, `chevron-right`, `chevron-up-down`, `cog`, `computer-desktop`, `credit-card`, `currency-dollar`, `document-text`, `eye`, `eye-slash`, `folder-git-2`, `heart`, `home`, `magnifying-glass`, `moon`, `pencil-square`, `plus`, `shield`, `sparkles`, `sun`, `swatch`, `tag`, `trash`, `type`, `users`, `x-mark`
