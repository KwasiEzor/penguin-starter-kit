# Routes

Complete route reference for Penguin Starter Kit.

## Public

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/` | `home` | Welcome/landing page |
| GET | `/blog/{slug}` | `blog.show` | Public blog post with SEO |

## Guest Only

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/login` | `login` | Login form |
| GET | `/register` | `register` | Registration form |
| GET | `/forgot-password` | `password.request` | Forgot password form |
| GET | `/reset-password/{token}` | `password.reset` | Reset password form |

## Authenticated

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

## Admin

Requires `admin.access` permission.

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

## Payments

Requires payments to be enabled.

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/pricing` | `pricing` | Pricing page with plans and products |
| GET | `/billing` | `billing` | Billing and subscription management |
| GET | `/checkout/success` | `checkout.success` | Post-checkout success page |
| GET | `/checkout/cancel` | `checkout.cancel` | Post-checkout cancellation page |

## API

Sanctum-authenticated.

| Method | URI | Description |
|---|---|---|
| GET | `/api/user` | Authenticated user info |
| GET | `/api/posts` | List own posts (supports `?status=` filter) |
| POST | `/api/posts` | Create post |
| GET | `/api/posts/{post}` | Show post |
| PUT/PATCH | `/api/posts/{post}` | Update post |
| DELETE | `/api/posts/{post}` | Delete post |

Interactive API documentation is available at `/docs/api` (powered by Scramble).
