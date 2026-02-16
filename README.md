# Penguin Starter Kit

A production-ready Laravel starter kit built with **Livewire 4**, **Alpine.js 3**, **Tailwind CSS 4**, and the **PenguinUI** design system. It provides a complete authentication system, user settings, dark mode support, toast notifications, and two switchable layouts (sidebar and navbar) -- everything you need to start building your next Laravel application.

## Tech Stack

| Technology | Version | Role |
|---|---|---|
| PHP | 8.4 | Runtime |
| Laravel | 12 | Backend framework |
| Livewire | 4 | Reactive server-side components |
| Alpine.js | 3 | Lightweight client-side interactivity |
| Tailwind CSS | 4 | Utility-first CSS framework |
| PenguinUI | -- | Design system (CSS custom properties) |
| Pest | 3 | Testing framework |
| SQLite | -- | Default database |

## Features

### Authentication
- **Login** with email/password, "remember me" option, and rate limiting
- **Registration** with name, email, password, and password confirmation
- **Forgot Password** sends a reset link via email
- **Reset Password** with token validation
- **Email Verification** with resend capability
- **Confirm Password** for secure areas
- **Logout** with session invalidation and toast notification

### User Settings
- **Profile** -- update name and email (resets email verification on change)
- **Password** -- change password with current password verification
- **Appearance** -- light, dark, and system theme picker (persisted in localStorage)
- **Delete Account** -- modal confirmation with password verification

### UI System
- **25+ Blade components** styled with PenguinUI design tokens
- **Two layout options** -- sidebar (`<x-layouts.app>`) and top navbar (`<x-layouts.app-navbar>`)
- **Toast notifications** -- success, error, warning, info variants with auto-dismiss
- **Dark mode** -- full light/dark/system support using CSS custom properties
- **16 icon components** -- SVG Heroicons and custom icons
- **Responsive** -- mobile-friendly sidebar collapse and hamburger menu

### Developer Experience
- **61 tests** with 157 assertions covering all auth flows, components, and settings
- **TDD approach** -- tests written first, then implementation
- **Livewire Form Objects** for clean validation and form handling
- **Invokable actions** (e.g., `Logout`) for single-responsibility classes

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18
- npm

## Installation

```bash
# Clone the repository
git clone <your-repo-url> my-project
cd my-project

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Build front-end assets
npm run build
```

### Development Server

```bash
# Start the Laravel development server
php artisan serve

# In a separate terminal, start Vite for hot-reloading
npm run dev
```

Visit `http://localhost:8000` to see the welcome page. Register an account at `/register`.

## Project Structure

```
penguin-starter-kit/
├── app/
│   ├── Actions/Auth/
│   │   └── Logout.php                  # Invokable logout action
│   ├── Livewire/
│   │   ├── Auth/
│   │   │   ├── Login.php               # Login page component
│   │   │   ├── Register.php            # Registration page component
│   │   │   ├── ForgotPassword.php      # Forgot password page
│   │   │   ├── ResetPassword.php       # Reset password page
│   │   │   ├── VerifyEmail.php         # Email verification page
│   │   │   └── ConfirmPassword.php     # Password confirmation page
│   │   ├── Forms/Auth/
│   │   │   ├── LoginForm.php           # Login validation + rate limiting
│   │   │   └── RegisterForm.php        # Registration + user creation
│   │   ├── Concerns/
│   │   │   └── HasToast.php            # Toast dispatch trait
│   │   ├── Settings/
│   │   │   ├── Profile.php             # Update name/email
│   │   │   ├── Password.php            # Update password
│   │   │   └── Appearance.php          # Theme picker (Alpine.js)
│   │   ├── Dashboard.php               # Dashboard page
│   │   └── Settings.php                # Settings page with tabs
│   ├── Models/
│   │   └── User.php                    # User model with initials()
│   └── Support/
│       └── Toast.php                   # Session flash toast helper
│
├── resources/
│   ├── css/app.css                     # PenguinUI theme (CSS custom properties)
│   ├── js/app.js                       # Alpine.js + Livewire ESM bootstrap
│   └── views/
│       ├── components/
│       │   ├── layouts/
│       │   │   ├── app.blade.php           # Sidebar layout wrapper
│       │   │   ├── app-navbar.blade.php    # Navbar layout wrapper
│       │   │   ├── auth.blade.php          # Auth layout wrapper
│       │   │   ├── app/sidebar.blade.php   # Full sidebar HTML shell
│       │   │   ├── app/header.blade.php    # Full navbar HTML shell
│       │   │   └── auth/split.blade.php    # Split-screen auth layout
│       │   ├── icons/                  # 16 SVG icon components
│       │   ├── typography/             # heading, subheading
│       │   ├── button.blade.php        # Multi-variant button
│       │   ├── input.blade.php         # Text/password with show/hide
│       │   ├── checkbox.blade.php      # Styled checkbox
│       │   ├── dropdown.blade.php      # Alpine.js dropdown
│       │   ├── modal.blade.php         # Modal dialog with focus trap
│       │   ├── toast.blade.php         # Toast notification container
│       │   ├── separator.blade.php     # Horizontal/vertical divider
│       │   ├── sidebar.blade.php       # Sidebar navigation
│       │   ├── navbar.blade.php        # Top navbar navigation
│       │   └── ...                     # Other UI components
│       ├── livewire/
│       │   ├── auth/                   # Auth page views
│       │   ├── settings/               # Settings tab views
│       │   ├── dashboard.blade.php
│       │   └── settings.blade.php
│       └── partials/
│           ├── head.blade.php          # Meta, fonts, Vite
│           └── scripts.blade.php       # Theme manager JS
│
├── routes/web.php                      # All application routes
└── tests/
    ├── Feature/
    │   ├── Auth/                       # 8 auth test files
    │   ├── Components/                 # 4 component test files
    │   ├── Settings/                   # 4 settings test files
    │   └── DashboardTest.php
    └── Unit/
        ├── ToastTest.php
        └── UserTest.php
```

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/` | home | Welcome page |
| GET | `/login` | login | Login form (guest only) |
| GET | `/register` | register | Registration form (guest only) |
| GET | `/forgot-password` | password.request | Forgot password form (guest only) |
| GET | `/reset-password/{token}` | password.reset | Reset password form (guest only) |
| GET | `/dashboard` | dashboard | Dashboard (authenticated) |
| GET | `/settings` | settings | Settings page (authenticated) |
| GET | `/verify-email` | verification.notice | Email verification notice (authenticated) |
| GET | `/confirm-password` | password.confirm | Password confirmation (authenticated) |
| POST | `/logout` | logout | Logout action (authenticated) |
| GET | `/email/verify/{id}/{hash}` | verification.verify | Email verification link (signed) |

## Layouts

The starter kit ships with two interchangeable layouts for authenticated pages.

### Sidebar Layout (Default)

```blade
{{-- In your Livewire component --}}
#[Layout('components.layouts.app')]
```

A fixed left sidebar with navigation links, user avatar with initials, and a dropdown menu for settings/logout.

### Navbar Layout

```blade
{{-- In your Livewire component --}}
#[Layout('components.layouts.app-navbar')]
```

A top navigation bar with a responsive hamburger menu for mobile. Switch any page to this layout by changing the `#[Layout]` attribute on the Livewire component.

## Blade Components

All components use PenguinUI's semantic design tokens for consistent theming.

### Button

```blade
<x-button variant="primary">Save</x-button>
<x-button variant="danger" size="sm">Delete</x-button>
<x-button variant="outline" href="/settings">Settings</x-button>
```

**Variants:** `primary`, `secondary`, `outline`, `ghost`, `info`, `danger`, `success`, `warning`
**Sizes:** `xs`, `sm`, `md`, `lg`

### Input

```blade
{{-- Text input --}}
<x-input type="email" wire:model="email" placeholder="email@example.com" />

{{-- Password input with show/hide toggle --}}
<x-input variant="password" wire:model="password" placeholder="Password" />
```

### Modal

```blade
<x-modal name="confirm-delete">
    <x-slot:trigger>
        <x-button variant="danger">Delete Account</x-button>
    </x-slot:trigger>

    <div class="p-6">
        <h2>Are you sure?</h2>
        {{-- Modal content --}}
    </div>
</x-modal>
```

### Toast

Toasts are dispatched from Livewire components using the `HasToast` trait or the `Toast` helper:

```php
// In a Livewire component
use App\Livewire\Concerns\HasToast;

class MyComponent extends Component
{
    use HasToast;

    public function save()
    {
        // ... save logic
        $this->toast('success', 'Settings saved successfully!');
    }
}

// Or using the session helper
use App\Support\Toast;

Toast::success('Your account has been created!');
Toast::error('Something went wrong.');
Toast::warning('Please verify your email.');
Toast::info('Check your inbox.');
```

### Other Components

| Component | Usage |
|---|---|
| `<x-input-label>` | Form labels |
| `<x-input-error>` | Validation error messages |
| `<x-checkbox>` | Styled checkbox |
| `<x-dropdown>` | Alpine.js dropdown with keyboard navigation |
| `<x-dropdown-link>` | Dropdown menu item |
| `<x-link>` | Styled anchor link |
| `<x-separator>` | Horizontal/vertical divider with optional text |
| `<x-typography.heading>` | Page headings |
| `<x-typography.subheading>` | Secondary text |

## Dark Mode

The starter kit supports three theme modes: **Light**, **Dark**, and **System** (follows OS preference).

The theme is managed by:
1. **CSS custom properties** in `resources/css/app.css` -- PenguinUI design tokens for both light and dark palettes
2. **ThemeManager JS** in `partials/scripts.blade.php` -- reads from `localStorage` and applies the `dark` class to `<html>`
3. **Appearance settings** -- an Alpine.js component in the settings page that lets users pick their preferred theme

The theme persists across sessions via `localStorage.theme`.

## Testing

```bash
# Run the full test suite
php artisan test

# Run a specific test file
php artisan test tests/Feature/Auth/AuthFlowTest.php

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage
```

The test suite covers:
- **Auth flows** -- register, login, logout, forgot/reset password, email verification, password confirmation
- **End-to-end flow** -- register a user, logout, then login with the same credentials
- **Validation** -- empty fields, invalid emails, short passwords, mismatched confirmations, duplicate emails
- **Components** -- button variants/sizes, input types, modal rendering, separator styles
- **Settings** -- profile update, password change, account deletion
- **Access control** -- guest redirect to login, authenticated-only pages

## Customization

### Changing the App Name

Update `APP_NAME` in your `.env` file:

```
APP_NAME="My Application"
```

The name appears in the sidebar/navbar, auth pages, and page titles.

### Changing Theme Colors

Edit the CSS custom properties in `resources/css/app.css`:

```css
@theme {
    /* Primary color */
    --color-primary: var(--color-indigo-600);
    --color-on-primary: var(--color-white);

    /* Dark mode primary */
    --color-primary-dark: var(--color-indigo-400);
    --color-on-primary-dark: var(--color-indigo-950);
}
```

Then rebuild assets with `npm run build`.

### Switching Default Layout

In any Livewire component, change the `#[Layout]` attribute:

```php
// Sidebar layout (default)
#[Layout('components.layouts.app')]

// Navbar layout
#[Layout('components.layouts.app-navbar')]
```

### Adding New Pages

1. Create a Livewire component:
   ```bash
   php artisan make:livewire MyPage
   ```

2. Set the layout in the component class:
   ```php
   #[Layout('components.layouts.app')]
   final class MyPage extends Component { }
   ```

3. Add a route in `routes/web.php`:
   ```php
   Route::get('/my-page', MyPage::class)->name('my-page');
   ```

4. Add a navigation link in `components/sidebar.blade.php`:
   ```blade
   <x-sidebar-link :href="route('my-page')" :active="request()->routeIs('my-page')" wire:navigate>
       <x-icons.home class="size-5" />
       My Page
   </x-sidebar-link>
   ```

## Architecture Notes

- **Livewire 4** handles all server-side reactivity. Alpine.js is imported from Livewire's ESM bundle to avoid double initialization.
- **Livewire Form Objects** (`LoginForm`, `RegisterForm`) encapsulate validation rules and form logic.
- **Invokable Actions** (e.g., `Logout`) follow single-responsibility for non-component logic.
- **PenguinUI tokens** use semantic names (`surface`, `primary`, `on-surface`, `outline`) instead of raw colors for consistent theming.
- **The User model** has a `hashed` cast on `password`, so never manually call `Hash::make()` when creating users.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
