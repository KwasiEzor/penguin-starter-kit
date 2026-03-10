# Customization

## Changing the App Name

Update `APP_NAME` in your `.env` file:

```ini
APP_NAME="My Application"
```

Or configure it from the admin panel: **Admin > Website Settings > Site Name**.

## Changing Theme Colors

### Option 1: Admin Panel (Recommended)

Go to **Admin > Theme** and choose a preset or customize individual colors, radius, shadows, fonts, and transition settings. Changes apply instantly.

### Option 2: CSS Custom Properties

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

## Switching Layouts

In any Livewire component, change the `#[Layout]` attribute:

```php
// Sidebar layout (default)
#[Layout('components.layouts.app')]

// Navbar layout
#[Layout('components.layouts.app-navbar')]
```

Available layouts:

| Layout | Description |
|---|---|
| `components.layouts.app` | Sidebar layout with fixed left navigation |
| `components.layouts.app-navbar` | Top navbar layout with responsive hamburger menu |
| `components.layouts.auth` | Centered auth layout |
| `components.layouts.auth.split` | Split-screen auth layout |
| `components.layouts.blog` | Public blog layout |

## Adding New Pages

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

## Seeding Demo Data

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

## Using Toasts

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
