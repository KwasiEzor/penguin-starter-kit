<p align="center">
  <img src="https://raw.githubusercontent.com/kwasiezor/penguin-starter-kit/main/public/admin-dashboard.png" alt="Penguin Starter Kit - Admin Dashboard" width="100%">
</p>

<h1 align="center">Penguin Starter Kit</h1>

<p align="center">
  <strong>A production-ready Laravel 12 starter kit for building modern SaaS applications.</strong>
</p>

<p align="center">
  Built with the TALL stack: <b>Tailwind CSS 4</b> + <b>Alpine.js 3</b> + <b>Laravel 12</b> + <b>Livewire 4</b>
</p>

<p align="center">
  <a href="https://github.com/kwasiezor/penguin-starter-kit/actions/workflows/ci.yml"><img src="https://github.com/kwasiezor/penguin-starter-kit/actions/workflows/ci.yml/badge.svg" alt="CI"></a>
  <a href="https://github.com/kwasiezor/penguin-starter-kit/actions/workflows/security.yml"><img src="https://github.com/kwasiezor/penguin-starter-kit/actions/workflows/security.yml/badge.svg" alt="Security"></a>
  <a href="https://packagist.org/packages/kwasiezor/penguin-starter-kit"><img src="https://img.shields.io/packagist/v/kwasiezor/penguin-starter-kit.svg" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/kwasiezor/penguin-starter-kit"><img src="https://img.shields.io/packagist/dt/kwasiezor/penguin-starter-kit.svg" alt="Total Downloads"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

<p align="center">
  <a href="#-quick-start">Quick Start</a> &bull;
  <a href="#-features">Features</a> &bull;
  <a href="#-tech-stack">Tech Stack</a> &bull;
  <a href="https://kwasiezor.github.io/penguin-starter-kit/">Documentation</a> &bull;
  <a href="#-contributing">Contributing</a>
</p>

---

## About

Penguin Starter Kit is a premium, open-source Laravel starter kit that gives you everything you need to launch a SaaS application. It ships with a complete authentication system, blog engine with posts/tags/categories, AI agent integration with multi-provider support, a full admin dashboard with user/role management, Stripe payments, real-time notifications, a REST API, and 40+ reusable Blade components -- all built on the **PenguinUI** design system.

Stop building boilerplate. Start building your product.

---

## Quick Start

### Installation via Packagist (Recommended)

```bash
composer create-project kwasiezor/penguin-starter-kit my-app
```

This automatically:
1. Downloads the latest stable version
2. Installs all PHP dependencies
3. Creates your `.env` file and generates an app key
4. Sets up a local SQLite database and runs migrations

Then start the development server:

```bash
cd my-app
npm install && npm run dev    # Terminal 1: Vite dev server
php artisan serve             # Terminal 2: Laravel server
```

Visit `http://localhost:8000` and register your first account.

### Manual Installation

```bash
git clone https://github.com/kwasiezor/penguin-starter-kit.git my-app
cd my-app
composer setup    # install deps, generate key, run migrations
npm run dev       # start Vite
```

### One-Command Development

Start all services (server, queue, logs, Vite, Reverb) simultaneously:

```bash
composer dev
```

This runs Laravel server, queue worker, Pail log viewer, Vite, and Reverb WebSocket server in parallel with color-coded output.

---

## Tech Stack

| Technology | Version | Role |
|---|---|---|
| **PHP** | 8.4+ | Runtime |
| **Laravel** | 12 | Backend framework |
| **Livewire** | 4 | Reactive server-side components |
| **Alpine.js** | 3 | Lightweight client-side interactivity |
| **Tailwind CSS** | 4 | Utility-first CSS framework |
| **PenguinUI** | -- | Design system (CSS custom properties) |
| **Pest** | 3 | Testing framework |
| **SQLite** | -- | Default database (swap to MySQL/PostgreSQL) |
| **Spatie Permission** | 7 | Roles and permissions (RBAC) |
| **Spatie Media Library** | 11 | File/image uploads (avatars, featured images) |
| **Spatie Tags** | 4 | Post tagging system |
| **Spatie Health** | 1 | Application health monitoring |
| **Laravel Sanctum** | 4 | API token authentication |
| **Laravel Cashier** | 16 | Stripe payments and subscriptions |
| **Laravel Reverb** | 1 | Real-time WebSocket broadcasting |
| **Laravel AI** | 0.2 | AI agent framework |
| **Rich Text Laravel** | 3 | Trix rich text editor integration |
| **Scramble** | 0.13 | Auto-generated API documentation |
| **PHPStan / Larastan** | 3 | Static analysis |
| **Rector** | 2 | Automated refactoring |
| **Laravel Pint** | 1 | Code style fixer |
| **Prettier** | 3 | Blade/JS/CSS formatting |

---

## Features

### Authentication

- **Login** with email/password, "remember me" option, and rate limiting (5 requests/minute)
- **Registration** with name, email, password, and password confirmation (3 requests/minute)
- **Forgot Password** sends a reset link via email (3 requests/minute)
- **Reset Password** with secure token validation
- **Email Verification** with resend capability
- **Confirm Password** gate for secure areas
- **Logout** with session invalidation and toast notification
- **Admin-configurable settings**: toggle registration, domain whitelist, password complexity rules, session lifetime

### Admin Dashboard

The admin panel is accessible to users with the `admin.access` permission and provides full control over the application.

**Dashboard Overview:**
- Total users, total posts, published posts counts
- Recent users and recent posts activity feed
- Payment stats (active subscriptions, monthly revenue) when payments are enabled

**User Management:**
- List all users with search and pagination
- Create, edit, and delete users
- Assign roles with granular permission checkboxes
- Upload and manage user avatars

**Role Management:**
- Create, edit, and delete custom roles
- 15 granular permissions across 6 groups
- Safeguards: cannot delete the admin role, cannot demote the last admin, cannot delete roles with assigned users

**Website Settings:**
- Site name, tagline, and contact email
- Logo uploads (light mode and dark mode variants)
- Favicon upload
- SEO settings (title, description, keywords, social sharing image)
- Analytics integration (Google Analytics, GTM, Meta Pixel)
- Custom header/footer script injection

**Theme Settings:**
- 8 built-in theme presets (Default, Midnight, Ocean, Slate, Forest, Rose, Vintage, Cyberpunk)
- Full color customization for light mode, dark mode, and semantic colors
- Configurable border radius, button radius, transition speed, easing, and shadows
- 10 font families available via Bunny Fonts
- Live preview and instant application

**Authentication Settings:**
- Toggle user registration on/off
- Email verification requirements
- Domain whitelist for registration
- Social login configuration (Google, GitHub, Facebook)
- Password policy (min length, mixed case, symbols, numbers)
- Session lifetime configuration

**Category Management:**
- CRUD for post categories with auto-generated slugs
- Category descriptions and colors
- Safeguards: cannot delete categories with attached posts

**AI Settings:**
- Toggle AI features on/off
- Manage global API keys for OpenAI, Anthropic, and Gemini
- Keys encrypted at rest

**Payment Settings:**
- Toggle payments on/off (feature-flagged)
- Manage Stripe API keys (encrypted at rest)
- CRUD for subscription plans (name, price, interval, features, Stripe price ID)
- CRUD for one-time products
- Transaction history viewer

**Health Monitoring:**
- Application health dashboard at `/admin/health`
- Checks: optimized app, debug mode, environment, database connectivity
- Powered by Spatie Laravel Health

**Component Playground:**
- Interactive preview of all UI components
- Test buttons, inputs, modals, badges, and more in isolation

### Roles & Permissions

Three built-in roles with configurable permissions:

| Role | Permissions |
|---|---|
| **Administrator** | All 15 permissions |
| **Editor** | Admin access, all post permissions, view users |
| **User** | View posts, create posts |

**15 granular permissions across 6 groups:**

| Group | Permissions |
|---|---|
| **Users** | `users.view`, `users.create`, `users.edit`, `users.delete` |
| **Posts** | `posts.view`, `posts.create`, `posts.edit`, `posts.delete`, `posts.publish` |
| **Admin** | `admin.access`, `settings.manage` |
| **Roles** | `roles.view`, `roles.edit` |
| **Payments** | `payments.manage` |
| **AI** | `ai-agents.manage` |

Custom roles can be created with any combination of these permissions. Powered by [Spatie Laravel Permission](https://github.com/spatie/laravel-permission).

### Posts & Blog

A complete blog engine with rich content authoring:

- **Full CRUD** -- create, read, update, and delete posts scoped to the authenticated user
- **Rich text editor** -- Trix editor for composing post content with formatting, images, and attachments
- **Draft/Published status** with automatic `published_at` timestamp management
- **Auto-generated slugs** from post titles with unique suffix handling
- **Tag system** via Spatie Tags -- comma-separated input, filter by tag
- **Category system** -- polymorphic categories with admin CRUD, filter posts by category
- **Featured images** via Spatie Media Library with upload, replacement, and removal
- **SEO fields** -- meta title, meta description, and excerpt per post
- **Data table** with search, status filter, tag filter, category filter, sortable columns, and pagination
- **Public blog** at `/blog/{slug}` with SEO meta tags and Open Graph image support
- **Authorization** via `PostPolicy` -- owners manage their posts; users with elevated permissions can act on any post
- **Real-time notifications** -- when a post is published, all other users are notified via database notification and WebSocket push

### AI Agents

A multi-provider AI agent system built on [Laravel AI](https://github.com/laravel/ai):

- **Full CRUD** -- create, edit, and delete AI agents with name, description, system prompt, and model configuration
- **Multi-provider support** -- OpenAI (GPT-4o, GPT-4o Mini, GPT-4 Turbo), Anthropic (Claude Sonnet 4.5, Claude Haiku 4.5), and Gemini (2.0 Flash, 1.5 Pro, 1.5 Flash)
- **Streaming responses** -- real-time token-by-token output streaming
- **Execution tracking** -- each agent run creates an `AiExecution` record with input, output, token usage, and execution time
- **API key management** -- per-user personal API keys and admin-configured global fallback keys, all encrypted at rest
- **Layered key resolution** -- user keys take priority over global keys
- **Visibility controls** -- public agents visible to all users, private agents restricted to their owner
- **Authorization** via `AiAgentPolicy` -- owners manage their agents; admins can manage any agent
- **3 pre-seeded agent templates**: Professional Copy Editor, SEO Content Wizard, Code Architect

### Stripe Payments

Fully feature-flagged payment system powered by [Laravel Cashier](https://laravel.com/docs/billing):

- **Feature-flagged** -- admin toggles payments on/off; all payment routes return 404 when disabled, UI elements are hidden
- **Stripe key management** -- publishable key, secret key (encrypted at rest), webhook secret, and currency stored in the database
- **Subscription plans** -- name, description, price, billing interval (monthly/yearly), feature list, Stripe price ID, active/featured toggles
- **One-time products** -- name, description, price, Stripe price ID, active toggle
- **Checkout** via Stripe Checkout Sessions for both subscriptions and one-time purchases
- **Billing portal** -- users manage subscriptions through Stripe's Customer Portal
- **Order tracking** -- purchase records with status (pending, completed, failed, refunded)
- **Webhook handling** -- listens for `checkout.session.completed` to record one-time purchases
- **Pricing page** -- public-facing page displaying all active plans and products

### Notifications & Real-time

- **Database notifications** -- when a post is published, all other users receive a notification via a queued job
- **Real-time push** via Laravel Reverb WebSockets on private per-user channels
- **Notification center** in the sidebar -- bell icon with unread count, last 10 notifications, mark as read
- **Instant toast** on push -- new post notifications appear as a toast without a page refresh

### API Layer

RESTful API with automatic documentation:

- **Sanctum-authenticated** REST API for posts (`/api/posts`)
- **Full CRUD** -- list (with `?status=` filter), create (with tags array), show, update, delete
- **Form Request validation** -- dedicated `StorePostRequest` and `UpdatePostRequest` classes
- **API Resources** -- `PostResource` and `UserResource` for consistent JSON output
- **Token management UI** in settings -- create named tokens, view existing tokens, revoke tokens
- **Interactive API documentation** at `/docs/api` powered by [Scramble](https://scramble.dedoc.co/) with Bearer auth
- **Rate limiting** -- 60 requests per minute per user/IP

### Spotlight Search

- **Cmd+K / Ctrl+K** opens a search overlay from anywhere in the app
- **Post search** -- queries the user's posts by title or body (top 5 results)
- **Page search** -- filters navigation pages (Dashboard, Posts, Create Post, Settings)
- Closes on Escape or click outside

### User Settings

Tabbed settings page with five sections:

- **Profile** -- update name, email (resets email verification on change), and avatar upload/removal
- **Password** -- change password with current password verification
- **Appearance** -- light, dark, and system theme picker (persisted in localStorage)
- **AI API Keys** -- manage personal API keys per provider (OpenAI, Anthropic, Gemini), encrypted at rest
- **API Tokens** -- create, view, and revoke personal access tokens (token shown once on creation)
- **Delete Account** -- modal confirmation with password verification

---

## UI System

### PenguinUI Design System

All components use semantic design tokens for consistent theming across light and dark modes. The design system is built entirely with CSS custom properties, making it trivial to rebrand.

**Semantic tokens:** `surface`, `surface-alt`, `on-surface`, `on-surface-strong`, `primary`, `on-primary`, `secondary`, `on-secondary`, `outline`, `outline-strong`, `info`, `success`, `warning`, `danger`

### 40+ Blade Components

#### Form Components

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

#### Layout Components

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

#### Data Display

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

#### Feedback & Overlay

| Component | Description |
|---|---|
| `<x-modal>` | Modal dialog with trigger slot |
| `<x-toast>` | Toast notifications (success, error, warning, info) with auto-dismiss |
| `<x-alert>` | Alert messages |
| `<x-tooltip>` | Tooltip on hover |
| `<x-dropdown>` | Alpine.js dropdown with keyboard navigation |
| `<x-dropdown-link>` | Dropdown menu item |

#### Navigation

| Component | Description |
|---|---|
| `<x-sidebar-link>` | Sidebar navigation link |
| `<x-nav-link>` | Navbar navigation link |
| `<x-breadcrumbs>` | Breadcrumb navigation |
| `<x-breadcrumb-item>` | Individual breadcrumb |
| `<x-link>` | Styled anchor link |

#### Media

| Component | Description |
|---|---|
| `<x-carousel>` | Image/content carousel |
| `<x-carousel-item>` | Carousel slide |
| `<x-accordion>` | Accordion container |
| `<x-accordion-item>` | Accordion panel |
| `<x-image-card>` | Image card with aspect ratio and animation |

#### Typography & Branding

| Component | Description |
|---|---|
| `<x-typography.heading>` | Page headings |
| `<x-typography.subheading>` | Secondary text |
| `<x-app-logo>` | Application logo |
| `<x-app-logo-icon>` | Application logo icon |
| `<x-auth-header>` | Auth page header |

#### 25+ Icon Components

SVG Heroicons and custom icons available as Blade components:

`arrow-path`, `arrow-right-start-on-rectangle`, `arrow-up-right`, `bars-3`, `book-open-text`, `check-circle`, `check`, `chevron-down`, `chevron-right`, `chevron-up-down`, `cog`, `computer-desktop`, `credit-card`, `currency-dollar`, `document-text`, `eye`, `eye-slash`, `folder-git-2`, `heart`, `home`, `magnifying-glass`, `moon`, `pencil-square`, `plus`, `shield`, `sparkles`, `sun`, `swatch`, `tag`, `trash`, `type`, `users`, `x-mark`

Usage: `<x-icons.sparkles class="size-5" />`

### Using Toasts

```php
// In a Livewire component (trait)
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

// Or using the session helper (from controllers, actions, etc.)
use App\Support\Toast;

Toast::success('Your account has been created!');
Toast::error('Something went wrong.');
Toast::warning('Please verify your email.');
Toast::info('Check your inbox.');
```

### Dark Mode

Three theme modes: **Light**, **Dark**, and **System** (follows OS preference).

The theme is managed by:
1. **CSS custom properties** in `resources/css/app.css` -- PenguinUI design tokens for both light and dark palettes
2. **ThemeManager JS** in `partials/scripts.blade.php` -- reads from `localStorage` and applies the `dark` class to `<html>`
3. **Appearance settings** -- users pick their preferred theme in Settings > Appearance

The theme persists across sessions via `localStorage.theme`.

### Admin Theme Presets

The admin can change the entire application's look and feel from **Admin > Theme**:

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

Each preset customizes: surface colors, primary/secondary colors, semantic colors, border radius, button radius, transition speed, easing, shadows, and font family.

---

## Routes

### Public

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/` | `home` | Welcome/landing page |
| GET | `/blog/{slug}` | `blog.show` | Public blog post with SEO |

### Guest Only

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/login` | `login` | Login form |
| GET | `/register` | `register` | Registration form |
| GET | `/forgot-password` | `password.request` | Forgot password form |
| GET | `/reset-password/{token}` | `password.reset` | Reset password form |

### Authenticated

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/dashboard` | `dashboard` | User dashboard |
| GET | `/posts` | `posts.index` | Posts list with filters |
| GET | `/posts/create` | `posts.create` | Create post form |
| GET | `/posts/{post}/edit` | `posts.edit` | Edit post form |
| GET | `/agents` | `agents.index` | AI agents list |
| GET | `/agents/create` | `agents.create` | Create AI agent form |
| GET | `/agents/{aiAgent}` | `agents.show` | AI agent detail and execution |
| GET | `/agents/{aiAgent}/edit` | `agents.edit` | Edit AI agent form |
| GET | `/settings` | `settings` | User settings (5 tabs) |
| GET | `/verify-email` | `verification.notice` | Email verification notice |
| GET | `/confirm-password` | `password.confirm` | Password confirmation |
| POST | `/logout` | `logout` | Logout action |

### Admin (requires `admin.access` permission)

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/admin/dashboard` | `admin.dashboard` | Admin overview with stats |
| GET | `/admin/users` | `admin.users.index` | User management |
| GET | `/admin/users/create` | `admin.users.create` | Create user |
| GET | `/admin/users/{user}/edit` | `admin.users.edit` | Edit user |
| GET | `/admin/roles` | `admin.roles.index` | Role management |
| GET | `/admin/roles/create` | `admin.roles.create` | Create role |
| GET | `/admin/roles/{role}/edit` | `admin.roles.edit` | Edit role |
| GET | `/admin/categories` | `admin.categories.index` | Category management |
| GET | `/admin/ai-settings` | `admin.ai-settings` | AI feature settings |
| GET | `/admin/auth-settings` | `admin.auth-settings` | Authentication settings |
| GET | `/admin/settings` | `admin.settings` | Website settings |
| GET | `/admin/theme` | `admin.theme` | Theme customization |
| GET | `/admin/payments` | `admin.payments` | Payment settings |
| GET | `/admin/playground` | `admin.playground` | Component playground |
| GET | `/admin/health` | `admin.health` | Health monitoring |

### Payments (requires payments to be enabled)

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/pricing` | `pricing` | Pricing page with plans and products |
| GET | `/billing` | `billing` | User billing and subscription management |
| GET | `/checkout/success` | `checkout.success` | Post-checkout success page |
| GET | `/checkout/cancel` | `checkout.cancel` | Post-checkout cancellation page |

### API (Sanctum-authenticated)

| Method | URI | Description |
|---|---|---|
| GET | `/api/user` | Authenticated user info |
| GET | `/api/posts` | List own posts (supports `?status=` filter) |
| POST | `/api/posts` | Create post |
| GET | `/api/posts/{post}` | Show post |
| PUT/PATCH | `/api/posts/{post}` | Update post |
| DELETE | `/api/posts/{post}` | Delete post |

Interactive API documentation is available at `/docs/api` (powered by Scramble).

---

## Configuration

### Environment Variables

Add the following to your `.env` file to enable optional features:

```env
# ─── App ───────────────────────────────────────────────
APP_NAME="My Application"
APP_URL=http://localhost

# ─── Stripe Payments ───────────────────────────────────
# (or configure via Admin > Payments in the UI)
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=usd

# ─── Real-time Broadcasting (Laravel Reverb) ──────────
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_APP_ID=your-app-id
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

# ─── AI Providers ─────────────────────────────────────
# (or configure via Admin > AI Settings / User Settings)
OPENAI_API_KEY=sk-...
ANTHROPIC_API_KEY=sk-ant-...
GEMINI_API_KEY=...

# ─── Mail ─────────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS="hello@example.com"
```

### Database Configuration

SQLite is the default database for zero-config setup. To switch to MySQL or PostgreSQL, update your `.env`:

```env
# MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penguin
DB_USERNAME=root
DB_PASSWORD=

# PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=penguin
DB_USERNAME=postgres
DB_PASSWORD=
```

### Development Server

```bash
# Option 1: Start all services at once
composer dev

# Option 2: Start services individually
php artisan serve              # Laravel server
npm run dev                    # Vite hot-reloading
php artisan queue:listen       # Queue worker
php artisan reverb:start       # WebSocket server (optional)
php artisan pail               # Log viewer (optional)
```

---

## Project Structure

```
penguin-starter-kit/
├── app/
│   ├── Actions/Auth/           # Invokable action classes (Logout)
│   ├── Enums/                  # AiProviderEnum, PermissionEnum, RoleEnum
│   ├── Events/                 # NewPostPublished event
│   ├── Http/
│   │   ├── Controllers/Api/    # PostController (API)
│   │   ├── Middleware/         # EnsurePaymentsEnabled, EnsureUserIsAdmin
│   │   ├── Requests/Api/      # StorePostRequest, UpdatePostRequest
│   │   └── Resources/         # PostResource, UserResource
│   ├── Jobs/                   # NotifyUsersOfNewPost
│   ├── Listeners/              # StripeEventListener
│   ├── Livewire/
│   │   ├── Admin/              # Dashboard, Users, Roles, Categories, Settings...
│   │   ├── AiAgents/           # Index, Create, Edit, Show
│   │   ├── Auth/               # Login, Register, ForgotPassword, ResetPassword...
│   │   ├── Blog/               # Public blog show
│   │   ├── Concerns/           # HasToast trait
│   │   ├── Forms/Auth/         # LoginForm, RegisterForm
│   │   ├── Posts/              # Index, Create, Edit
│   │   └── Settings/           # Profile, Password, Appearance, AiApiKeys, ApiTokens
│   ├── Models/                 # User, Post, AiAgent, AiApiKey, AiExecution, Category,
│   │                           # Order, Plan, Product, Setting
│   ├── Notifications/          # PostPublished
│   ├── Policies/               # PostPolicy, AiAgentPolicy
│   ├── Providers/              # AppServiceProvider
│   ├── Services/               # AiService, PaymentSettings, ThemeService,
│   │                           # WebsiteService, AuthSettingsService
│   └── Support/                # Toast helper
├── config/
│   ├── ai.php                  # AI provider configuration
│   ├── health.php              # Health check configuration
│   ├── theme.php               # Font families, radius, speed, easing, shadows
│   └── ...                     # Standard Laravel config files
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # 30+ migration files
│   └── seeders/                # RolesAndPermissions, AiAgentTemplates, DatabaseSeeder
├── resources/views/
│   ├── components/             # 40+ Blade components
│   ├── livewire/               # Livewire component views
│   ├── partials/               # head, scripts, theme
│   └── welcome.blade.php       # Landing page
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
├── tests/Feature/              # 290+ Pest tests
└── .github/
    ├── workflows/
    │   ├── ci.yml              # Tests, Pint, PHPStan, Rector, type coverage, Prettier
    │   ├── security.yml        # Composer & npm audit (weekly)
    │   ├── release-drafter.yml # Automatic release drafts
    │   └── dependabot-auto-merge.yml  # Auto-merge patch updates
    ├── dependabot.yml          # Weekly Composer, npm, and GitHub Actions updates
    └── release-drafter.yml     # Release draft template
```

---

## Customization

### Changing the App Name

Update `APP_NAME` in your `.env` file:

```env
APP_NAME="My Application"
```

Or configure it from the admin panel: **Admin > Website Settings > Site Name**.

### Changing Theme Colors

**Option 1: Admin Panel** (recommended)

Go to **Admin > Theme** and choose a preset or customize individual colors, radius, shadows, fonts, and transition settings. Changes apply instantly.

**Option 2: CSS Custom Properties**

Edit `resources/css/app.css`:

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

### Switching Layouts

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

### Seeding Demo Data

The starter kit includes seeders for bootstrapping:

```bash
# Run all seeders (roles, permissions, AI agent templates, test user)
php artisan db:seed

# The default test user:
# Email: test@example.com
# Password: password
```

The `DatabaseSeeder` creates:
- 3 roles (Administrator, Editor, User) with 15 permissions
- 3 AI agent templates (Copy Editor, SEO Wizard, Code Architect)
- 6 default categories (Technology, Tutorial, News, Opinion, Review, Guide)
- 1 test user

---

## Testing

The test suite includes **290+ tests** with **630+ assertions** covering every major feature.

```bash
# Run the full test suite
php artisan test

# Run tests in parallel
php artisan test --parallel

# Run a specific test file
php artisan test tests/Feature/Auth/AuthFlowTest.php

# Run with coverage (requires Xdebug or PCOV)
php artisan test --coverage

# Type coverage check
vendor/bin/pest --type-coverage --memory-limit=512M --min=100
```

### Test Coverage

| Area | What's Tested |
|---|---|
| **Auth** | Register, login, logout, forgot/reset password, email verification, password confirmation |
| **Posts** | CRUD, tags, categories, featured images, rich text, SEO fields, data table filters |
| **AI Agents** | CRUD, execution tracking, API key management, visibility controls, authorization |
| **Categories** | CRUD, polymorphic relationships, post integration, admin management |
| **Admin** | Dashboard stats, user management, role management, category management, AI settings, payment settings, plan/product CRUD |
| **Payments** | Pricing page visibility, billing page, feature flag behavior |
| **API** | Sanctum-authenticated post endpoints, form request validation |
| **Components** | Button, input, modal, separator, textarea, select, toggle, badge, card, avatar, alert, tabs, table, file upload |
| **Settings** | Profile update, password change, avatar upload, AI API keys, API tokens, account deletion |
| **Notifications** | Notification center, broadcasting events |
| **Spotlight Search** | Post search, page search, keyboard shortcut |
| **Models** | User, Post, AiAgent, Category relationships and scopes |

---

## Code Quality

The project ships with a comprehensive quality toolchain:

```bash
# Run all quality checks at once
composer quality

# Individual tools
composer lint          # Laravel Pint (fix)
composer lint:check    # Laravel Pint (check only)
composer analyse       # PHPStan static analysis
composer rector        # Rector automated refactoring (fix)
composer rector:check  # Rector (check only)
composer type-coverage # Pest type coverage (min 100%)

# Frontend formatting
npm run format         # Prettier (fix)
npm run format:check   # Prettier (check only)

# Run absolutely everything
composer check-all     # Pint + PHPStan + Rector + type coverage + Prettier + tests
```

### Coding Standards

- **Strict types** declared in all PHP files
- **`final` classes** on all Livewire components
- **Invokable actions** for single-responsibility classes
- **Livewire Form Objects** for validation and form logic
- **Enums** for roles, permissions, and AI providers
- **N+1 query prevention** in development mode
- **Lazy loading violations** logged in production

---

## CI/CD

### GitHub Actions Workflows

The project includes **4 CI workflows** that run on every push and PR to `main`:

#### CI Pipeline (`ci.yml`)

6 parallel jobs:

| Job | Description |
|---|---|
| **Tests** | PHP 8.4, SQLite, full Pest test suite with parallel execution |
| **Code Style** | Laravel Pint in check mode |
| **Static Analysis** | PHPStan with 512MB memory limit |
| **Rector** | Automated refactoring checks (dry run) |
| **Type Coverage** | Pest type coverage (minimum 100%) |
| **Prettier** | Blade, JS, and CSS formatting checks |

#### Security Audit (`security.yml`)

- Runs on push, PR, and **weekly schedule** (Monday 8:00 UTC)
- Audits both Composer and npm dependencies for known vulnerabilities

#### Release Drafter (`release-drafter.yml`)

- Automatically drafts releases when PRs are merged to `main`
- Categorizes changes: Features, Bug Fixes, Dependencies, Documentation, CI/CD
- Semantic versioning: major/minor/patch based on PR labels

#### Dependabot Auto-Merge (`dependabot-auto-merge.yml`)

- Automatically approves and squash-merges patch-level dependency updates
- Keeps dependencies current with minimal manual effort

### Dependabot Configuration

- **Composer** packages: weekly updates, max 10 open PRs
- **npm** packages: weekly updates, max 10 open PRs
- **GitHub Actions**: monthly updates

---

## Rate Limiting

| Route Group | Max Requests | Window |
|---|---|---|
| API (`/api/*`) | 60 | 1 minute |
| Login | 5 | 1 minute |
| Registration | 3 | 1 minute |
| Password Reset | 3 | 1 minute |

Rate limits are configured in `AppServiceProvider`. To customize:

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
});
```

---

## Deployment

### Production Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan icons:cache
npm run build
```

### Cache Headers

For production deployments, configure your web server for optimal caching:

<details>
<summary>Nginx</summary>

```nginx
location / {
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
    add_header Pragma "no-cache";
}
```

</details>

<details>
<summary>Apache</summary>

```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
</IfModule>

Header set Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0"
Header set Pragma "no-cache"
```

</details>

### Stripe Webhooks

For production Stripe integration:

```bash
# Set your webhook endpoint in the Stripe dashboard to:
# https://your-domain.com/stripe/webhook

# Or use Stripe CLI for local testing:
stripe listen --forward-to localhost:8000/stripe/webhook
```

---

## Staying Updated

As a starter kit, this project is meant to be the *beginning* of your application. We've included tools to help you stay current:

1. **Dependabot** -- pre-configured to keep Composer, npm, and GitHub Actions dependencies updated weekly via automated PRs. Patch updates are auto-merged.

2. **Release Drafter** -- automatically handles versioning and changelogs when you merge PRs to `main`.

3. **Upstream Sync** -- pull in new features or security fixes from the source:

    ```bash
    git remote add upstream https://github.com/kwasiezor/penguin-starter-kit.git
    git fetch upstream
    git merge upstream/main --allow-unrelated-histories
    ```

---

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
- **AI API keys** follow a layered resolution: per-user keys take priority over admin-configured global keys, all encrypted at rest.
- **Categories** use a polymorphic `categorizables` table, making them attachable to any model beyond just posts.
- **Theme system** generates CSS at runtime from database-stored overrides, validated and sanitized before output.
- **Website settings** (branding, SEO, analytics) are fully admin-configurable without code changes.

---

## Security

- All sensitive keys (Stripe secrets, AI API keys, social auth secrets) are **encrypted at rest** using Laravel's `Crypt::encryptString()`
- **Rate limiting** on all authentication and API endpoints
- **CSRF protection** on all web forms
- **Authorization policies** (`PostPolicy`, `AiAgentPolicy`) enforce ownership and role-based access
- **Form Request validation** on API endpoints
- **N+1 query prevention** via `Model::preventLazyLoading()` in development
- **Weekly security audits** via GitHub Actions (Composer and npm)
- **Spatie Health checks**: optimized app, debug mode, environment, database connectivity
- **CSS injection prevention** in theme system with hex color and CSS value validation

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-feature`
3. Ensure all quality checks pass: `composer check-all`
4. Commit your changes with a descriptive message
5. Push to your branch: `git push origin feature/my-feature`
6. Open a Pull Request

Please ensure your PR:
- Passes all CI checks (tests, Pint, PHPStan, Rector, type coverage, Prettier)
- Includes tests for new features
- Updates documentation as needed

---

## Support

- **Issues**: [github.com/kwasiezor/penguin-starter-kit/issues](https://github.com/kwasiezor/penguin-starter-kit/issues)
- **Source**: [github.com/kwasiezor/penguin-starter-kit](https://github.com/kwasiezor/penguin-starter-kit)

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">
  Built with care by <a href="https://github.com/kwasiezor">kwasiezor</a>
</p>
