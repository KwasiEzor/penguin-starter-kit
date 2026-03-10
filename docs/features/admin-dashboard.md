# Admin Dashboard

The admin panel is accessible to users with the `admin.access` permission and provides full control over the application.

## Dashboard Overview

- Total users, total posts, published posts counts
- Recent users and recent posts activity feed
- Payment stats (active subscriptions, monthly revenue) when payments are enabled

## User Management

- List all users with search and pagination
- Create, edit, and delete users
- Assign roles with granular permission checkboxes
- Upload and manage user avatars

## Role Management

- Create, edit, and delete custom roles
- 15 granular permissions across 6 groups
- Safeguards: cannot delete the admin role, cannot demote the last admin, cannot delete roles with assigned users

## Website Settings

- Site name, tagline, and contact email
- Logo uploads (light mode and dark mode variants)
- Favicon upload
- SEO settings (title, description, keywords, social sharing image)
- Analytics integration (Google Analytics, GTM, Meta Pixel)
- Custom header/footer script injection

## Theme Settings

- 8 built-in [theme presets](/ui/theme-presets) (Default, Midnight, Ocean, Slate, Forest, Rose, Vintage, Cyberpunk)
- Full color customization for light mode, dark mode, and semantic colors
- Configurable border radius, button radius, transition speed, easing, and shadows
- 10 font families available via Bunny Fonts
- Live preview and instant application

## Authentication Settings

- Toggle user registration on/off
- Email verification requirements
- Domain whitelist for registration
- Social login configuration (Google, GitHub, Facebook)
- Password policy (min length, mixed case, symbols, numbers)
- Session lifetime configuration

## Category Management

- CRUD for post categories with auto-generated slugs
- Category descriptions and colors
- Safeguards: cannot delete categories with attached posts

## AI Settings

- Toggle AI features on/off
- Manage global API keys for OpenAI, Anthropic, and Gemini
- Keys encrypted at rest

## Payment Settings

- Toggle payments on/off (feature-flagged)
- Manage Stripe API keys (encrypted at rest)
- CRUD for subscription plans (name, price, interval, features, Stripe price ID)
- CRUD for one-time products
- Transaction history viewer

## Health Monitoring

- Application health dashboard at `/admin/health`
- Checks: optimized app, debug mode, environment, database connectivity
- Powered by Spatie Laravel Health

## Component Playground

- Interactive preview of all UI components
- Test buttons, inputs, modals, badges, and more in isolation

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/admin/dashboard` | `admin.dashboard` | Admin overview |
| GET | `/admin/users` | `admin.users.index` | User management |
| GET | `/admin/users/create` | `admin.users.create` | Create user |
| GET | `/admin/users/{user}/edit` | `admin.users.edit` | Edit user |
| GET | `/admin/roles` | `admin.roles.index` | Role management |
| GET | `/admin/roles/create` | `admin.roles.create` | Create role |
| GET | `/admin/roles/{role}/edit` | `admin.roles.edit` | Edit role |
| GET | `/admin/categories` | `admin.categories.index` | Categories |
| GET | `/admin/ai-settings` | `admin.ai-settings` | AI settings |
| GET | `/admin/auth-settings` | `admin.auth-settings` | Auth settings |
| GET | `/admin/settings` | `admin.settings` | Website settings |
| GET | `/admin/theme` | `admin.theme` | Theme customization |
| GET | `/admin/payments` | `admin.payments` | Payment settings |
| GET | `/admin/playground` | `admin.playground` | Component playground |
| GET | `/admin/health` | `admin.health` | Health monitoring |
