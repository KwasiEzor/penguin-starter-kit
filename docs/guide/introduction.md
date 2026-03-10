# Introduction

Penguin Starter Kit is a premium, open-source Laravel starter kit that gives you everything you need to launch a SaaS application. It ships with a complete authentication system, blog engine, AI agent integration, a full admin dashboard, Stripe payments, real-time notifications, a REST API, and 40+ reusable Blade components — all built on the **PenguinUI** design system.

**Stop building boilerplate. Start building your product.**

## What's Included

- **Authentication** — login, register, forgot/reset password, email verification, password confirmation
- **Blog Engine** — full CRUD with rich text, tags, categories, featured images, SEO fields
- **AI Agents** — multi-provider support (OpenAI, Anthropic, Gemini) with streaming and execution tracking
- **Admin Dashboard** — user/role management, website settings, theme customization, health monitoring
- **Stripe Payments** — subscription plans, one-time products, billing portal, webhooks
- **Real-time Notifications** — WebSocket push via Laravel Reverb, notification center, toast alerts
- **REST API** — Sanctum-authenticated endpoints with auto-generated documentation
- **40+ UI Components** — buttons, modals, tables, forms, and more with full dark mode support
- **Spotlight Search** — Cmd+K search overlay for posts and pages
- **290+ Tests** — comprehensive Pest test suite with 630+ assertions

## Tech Stack

| Technology | Version | Role |
|---|---|---|
| **PHP** | 8.4+ | Runtime |
| **Laravel** | 12 | Backend framework |
| **Livewire** | 4 | Reactive server-side components |
| **Alpine.js** | 3 | Client-side interactivity |
| **Tailwind CSS** | 4 | Utility-first CSS |
| **PenguinUI** | — | Design system (CSS custom properties) |
| **Pest** | 3 | Testing framework |
| **SQLite** | — | Default database |
| **Spatie Permission** | 7 | Roles and permissions (RBAC) |
| **Spatie Media Library** | 11 | File/image uploads |
| **Spatie Tags** | 4 | Post tagging system |
| **Spatie Health** | 1 | Application health monitoring |
| **Laravel Sanctum** | 4 | API token authentication |
| **Laravel Cashier** | 16 | Stripe payments |
| **Laravel Reverb** | 1 | WebSocket broadcasting |
| **Laravel AI** | 0.2 | AI agent framework |

## Philosophy

Penguin Starter Kit follows a few key principles:

1. **Convention over configuration** — sensible defaults that work out of the box
2. **Feature-flagged** — toggle payments, AI, and other features on or off
3. **Semantic design tokens** — theme once, apply everywhere
4. **Test everything** — 290+ tests ensure nothing breaks as you build
5. **Admin-configurable** — most settings are manageable from the admin panel without code changes

## Next Steps

- [Quick Start](/guide/quick-start) — install and run in under 2 minutes
- [Features](/features/authentication) — explore everything that's included
- [UI Components](/ui/components) — browse the 40+ component library
