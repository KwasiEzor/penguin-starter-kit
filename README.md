# Penguin Starter Kit

A production-ready Laravel starter kit built with **Livewire 4**, **Alpine.js 3**, **Tailwind CSS 4**, and the **PenguinUI** design system. It provides a complete authentication system, blog with posts and tags, admin dashboard with user/role management, Stripe payments, real-time notifications, API layer, and more -- everything you need to start building your next Laravel application.

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
| Spatie Permission | -- | Roles and permissions |
| Spatie Media Library | -- | File/image uploads (avatars, featured images) |
| Spatie Tags | -- | Post tagging |
| Laravel Sanctum | -- | API token authentication |
| Laravel Cashier | -- | Stripe payments and subscriptions |
| Laravel Reverb | -- | Real-time WebSocket broadcasting |

## Features

### Authentication
- **Login** with email/password, "remember me" option, and rate limiting
- **Registration** with name, email, password, and password confirmation
- **Forgot Password** sends a reset link via email
- **Reset Password** with token validation
- **Email Verification** with resend capability
- **Confirm Password** for secure areas
- **Logout** with session invalidation and toast notification

### Posts & Blog
- **Full CRUD** -- create, read, update, and delete posts scoped to the authenticated user
- **Draft/Published status** with automatic `published_at` timestamp management
- **Auto-generated slugs** from post titles with unique suffix handling
- **Tag system** via Spatie Tags -- comma-separated input, filter by tag
- **Featured images** via Spatie Media Library with upload and removal
- **SEO fields** -- meta title, meta description, and excerpt per post
- **Data table** with search, status filter, tag filter, sortable columns, and pagination
- **Public blog** at `/blog/{slug}` with SEO meta tags and Open Graph image
- **Authorization** via PostPolicy -- owners manage their posts; users with elevated permissions can act on any post

### Admin Dashboard
- **Overview stats** -- total users, total posts, published posts, recent users, recent posts
- **Payment stats** (conditional) -- active subscriptions and monthly revenue when payments are enabled
- **User management** -- list, create, edit, and delete users with role assignment and avatar upload
- **Role management** -- create, edit, and delete custom roles with granular permission checkboxes
- **Payment settings** -- toggle payments, manage Stripe keys, CRUD for plans and products, transaction history

### Roles & Permissions
- **Three built-in roles**: Administrator, Editor, User
- **13 granular permissions** across 5 groups: Users, Posts, Admin, Roles, Payments
- **Custom roles** -- create new roles with any combination of permissions
- **Safeguards** -- cannot delete the admin role, cannot demote the last admin, cannot delete a role with assigned users
- Powered by **Spatie Laravel Permission**

### Stripe Payments
- **Feature-flagged** -- admin toggles payments on/off from the dashboard; all payment routes return 404 when disabled
- **Stripe key management** -- publishable key, secret key (encrypted at rest), webhook secret, and currency stored in the database
- **Subscription plans** -- name, description, price, billing interval (monthly/yearly), feature list, Stripe price ID, active/featured toggles
- **One-time products** -- name, description, price, Stripe price ID, active toggle
- **Checkout** via Stripe Checkout Sessions for both subscriptions and one-time purchases
- **Billing portal** -- users manage subscriptions through Stripe's Customer Portal
- **Order tracking** -- purchase records with status (pending, completed, failed, refunded)
- **Webhook handling** -- listens for `checkout.session.completed` to record one-time purchases
- Powered by **Laravel Cashier**

### Notifications & Real-time
- **Database notifications** -- when a post is published, all other users receive a notification
- **Real-time push** via Laravel Reverb WebSockets on private per-user channels
- **Notification center** in the sidebar -- bell icon with unread count, last 10 notifications, mark as read
- **Instant toast** on push -- new post notifications appear as a toast without a page refresh

### API Layer
- **Sanctum-authenticated** REST API for posts (`/api/posts`)
- **Full CRUD** -- list (with status filter), create (with tags array), show, update, delete
- **Token management UI** in settings -- create named tokens, view existing tokens, revoke tokens
- Token shown once on creation, never displayed again

### Spotlight Search
- **Cmd+K / Ctrl+K** opens a search overlay from anywhere in the app
- **Post search** -- queries the user's posts by title or body (top 5 results)
- **Page search** -- filters navigation pages (Dashboard, Posts, Create Post, Settings)
- Closes on Escape or click outside

### User Settings
- **Profile** -- update name, email (resets email verification on change), and avatar upload/removal
- **Password** -- change password with current password verification
- **Appearance** -- light, dark, and system theme picker (persisted in localStorage)
- **API Tokens** -- create, view, and revoke personal access tokens
- **Delete Account** -- modal confirmation with password verification

### UI System
- **25+ Blade components** styled with PenguinUI design tokens
- **Two layout options** -- sidebar (`<x-layouts.app>`) and top navbar (`<x-layouts.app-navbar>`)
- **Toast notifications** -- success, error, warning, info variants with auto-dismiss
- **Dark mode** -- full light/dark/system support using CSS custom properties
- **16 icon components** -- SVG Heroicons and custom icons
- **Responsive** -- mobile-friendly sidebar collapse and hamburger menu

### CI/CD
- **GitHub Actions** workflow with two parallel jobs on push/PR to `main`:
  - **Tests** -- PHP 8.4, SQLite, runs full Pest test suite
  - **Code Style** -- Laravel Pint in check mode

### Developer Experience
- **236 tests** with 503 assertions covering auth, posts, admin, payments, API, components, and settings
- **Pest PHP** testing with Livewire test helpers
- **Livewire Form Objects** for clean validation and form handling
- **Invokable actions** (e.g., `Logout`) for single-responsibility classes
- **Strict types** and `final` classes throughout all Livewire components

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

# Seed roles and permissions
php artisan db:seed --class=RolesAndPermissionsSeeder

# Build front-end assets
npm run build
```

### Environment Variables

Add the following to your `.env` file to enable optional features:

```env
# Stripe Payments (or configure via Admin → Payments in the UI)
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=usd

# Real-time Broadcasting (Laravel Reverb)
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_APP_ID=your-app-id
REVERB_HOST=localhost
```

### Development Server

```bash
# Start the Laravel development server
php artisan serve

# In a separate terminal, start Vite for hot-reloading
npm run dev

# (Optional) Start Reverb for real-time features
php artisan reverb:start
```

Visit `http://localhost:8000` to see the welcome page. Register an account at `/register`.

## Routes

### Public

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/` | home | Welcome page |
| GET | `/blog/{slug}` | blog.show | Public blog post |

### Guest Only

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/login` | login | Login form |
| GET | `/register` | register | Registration form |
| GET | `/forgot-password` | password.request | Forgot password form |
| GET | `/reset-password/{token}` | password.reset | Reset password form |

### Authenticated

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/dashboard` | dashboard | User dashboard |
| GET | `/posts` | posts.index | Posts list |
| GET | `/posts/create` | posts.create | Create post form |
| GET | `/posts/{post}/edit` | posts.edit | Edit post form |
| GET | `/settings` | settings | User settings (profile, password, appearance, API tokens) |
| GET | `/verify-email` | verification.notice | Email verification notice |
| GET | `/confirm-password` | password.confirm | Password confirmation |
| POST | `/logout` | logout | Logout action |

### Admin (requires `admin.access` permission)

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/admin/dashboard` | admin.dashboard | Admin overview with stats |
| GET | `/admin/users` | admin.users.index | User management |
| GET | `/admin/users/create` | admin.users.create | Create user |
| GET | `/admin/users/{user}/edit` | admin.users.edit | Edit user |
| GET | `/admin/roles` | admin.roles.index | Role management |
| GET | `/admin/roles/create` | admin.roles.create | Create role |
| GET | `/admin/roles/{role}/edit` | admin.roles.edit | Edit role |
| GET | `/admin/payments` | admin.payments | Payment settings, plans, products, transactions |

### Payments (requires payments to be enabled)

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/pricing` | pricing | Pricing page with plans and products |
| GET | `/billing` | billing | User billing and subscription management |
| GET | `/checkout/success` | checkout.success | Post-checkout success page |
| GET | `/checkout/cancel` | checkout.cancel | Post-checkout cancellation page |

### API (Sanctum-authenticated)

| Method | URI | Description |
|---|---|---|
| GET | `/api/user` | Authenticated user info |
| GET | `/api/posts` | List own posts (supports `?status=` filter) |
| POST | `/api/posts` | Create post |
| GET | `/api/posts/{post}` | Show post |
| PUT/PATCH | `/api/posts/{post}` | Update post |
| DELETE | `/api/posts/{post}` | Delete post |

## Layouts

The starter kit ships with two interchangeable layouts for authenticated pages.

### Sidebar Layout (Default)

```blade
{{-- In your Livewire component --}}
#[Layout('components.layouts.app')]
```

A fixed left sidebar with navigation links, notification center, user avatar with initials, and a dropdown menu for settings/logout.

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
| `<x-toggle>` | Toggle switch |
| `<x-badge>` | Status badges |
| `<x-card>` | Content card |
| `<x-avatar>` | User avatar with initials fallback |
| `<x-alert>` | Alert messages |
| `<x-tabs>` | Tabbed navigation |
| `<x-table>` | Data table with headers and rows |
| `<x-stat-card>` | Dashboard statistic card |
| `<x-select>` | Dropdown select input |
| `<x-textarea>` | Multi-line text input |

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

The test suite includes **236 tests** with **503 assertions** covering:
- **Auth flows** -- register, login, logout, forgot/reset password, email verification, password confirmation
- **Posts** -- CRUD, tags, featured images, SEO fields, data table filters
- **Admin** -- dashboard stats, user management, role management, payment settings, plan/product CRUD
- **Payments** -- pricing page visibility, billing page, feature flag behavior
- **API** -- Sanctum-authenticated post endpoints
- **Components** -- button, input, modal, separator, textarea, select, toggle, badge, card, avatar, alert, tabs, table
- **Settings** -- profile update, password change, avatar upload, API tokens, account deletion
- **Notifications** -- notification center, broadcasting events
- **Spotlight search** -- post search, page search, keyboard shortcut

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
- **Spatie Media Library** handles all file uploads with `singleFile()` collections, so uploading a new file automatically replaces the old one.
- **Settings model** uses `Cache::rememberForever` with automatic invalidation on update for zero-cost reads.
- **Payment system** is fully feature-flagged -- toggling payments off makes all payment routes return 404 and hides UI elements.
- **Stripe secrets** are encrypted at rest using Laravel's `Crypt::encryptString()`.
- **Real-time broadcasting** uses per-user private channels, not shared public channels, ensuring notifications reach only intended recipients.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
