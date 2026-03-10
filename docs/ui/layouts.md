# Layouts

Penguin Starter Kit includes 5 layout components for different page types.

## Sidebar Layout

`<x-layouts.app>` — the default authenticated layout with a fixed left sidebar.

```php
#[Layout('components.layouts.app')]
final class Dashboard extends Component { }
```

Features:
- Fixed left sidebar with navigation links
- Notification center with bell icon and unread count
- User avatar and dropdown menu
- Spotlight search trigger
- Responsive: collapses to hamburger on mobile

## Navbar Layout

`<x-layouts.app-navbar>` — top navigation bar layout.

```php
#[Layout('components.layouts.app-navbar')]
final class MyPage extends Component { }
```

Features:
- Horizontal top navigation bar
- Responsive hamburger menu on mobile
- Same features as sidebar (notifications, user menu, search)

## Auth Layouts

### Centered

`<x-layouts.auth>` — centered card layout for authentication pages.

Used by: login, register, forgot password, reset password, email verification.

### Split Screen

`<x-layouts.auth.split>` — split-screen layout with decorative side panel.

Alternative auth layout with branding space on the left and form on the right.

## Blog Layout

`<x-layouts.blog>` — public blog layout with SEO meta tags.

Used by: public blog post pages at `/blog/{slug}`.

Features:
- Clean reading layout
- SEO meta tags and Open Graph support
- Featured image display
- Author and date information

## Switching Layouts

To switch a page's layout, change the `#[Layout]` attribute on the Livewire component:

```php
// From sidebar to navbar
#[Layout('components.layouts.app-navbar')]
final class MyPage extends Component { }
```
