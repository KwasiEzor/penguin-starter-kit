# Project Structure

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
│   ├── Models/                 # User, Post, AiAgent, AiApiKey, AiExecution,
│   │                           # Category, Order, Plan, Product, Setting
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
    │   └── dependabot-auto-merge.yml
    ├── dependabot.yml          # Weekly dependency updates
    └── release-drafter.yml     # Release draft template
```

## Key Directories

### `app/Livewire/`

All interactive pages are Livewire components. They're organized by feature:

- **Admin/** — admin dashboard, user management, role management, settings panels
- **AiAgents/** — AI agent CRUD and execution
- **Auth/** — login, register, password flows
- **Posts/** — post CRUD with data table
- **Settings/** — user profile, password, appearance, API keys

### `app/Models/`

Eloquent models with relationships, casts, and scopes:

- **User** — with `HasRoles`, `Billable`, `HasApiTokens`, `InteractsWithMedia`
- **Post** — with `HasTags`, `InteractsWithMedia`, category/user relationships
- **AiAgent** — with executions, API key resolution, visibility scopes
- **Setting** — key-value store with `Cache::rememberForever`

### `app/Services/`

Business logic extracted from Livewire components:

- **AiService** — provider resolution, API key retrieval, agent execution
- **ThemeService** — CSS generation from database-stored theme overrides
- **PaymentSettings** — Stripe key management with encryption
- **WebsiteService** — site name, SEO, analytics settings
- **AuthSettingsService** — registration toggles, password policies

### `resources/views/components/`

40+ Blade components using PenguinUI design tokens. See the [Components](/ui/components) reference for the full list.

### `tests/Feature/`

290+ Pest tests organized by feature area. See [Testing](/guide/testing) for details.
