---
layout: home

hero:
  name: Penguin Starter Kit
  text: Ship Your SaaS Faster
  tagline: A production-ready Laravel 12 starter kit with authentication, blog, AI agents, admin dashboard, payments, and 40+ UI components.
  actions:
    - theme: brand
      text: Get Started
      link: /guide/quick-start
    - theme: alt
      text: Features
      link: /features/authentication
    - theme: alt
      text: View on GitHub
      link: https://github.com/kwasiezor/penguin-starter-kit

features:
  - icon: "\U0001F916"
    title: AI Powered
    details: Multi-provider AI agent system with OpenAI, Anthropic, and Gemini. Streaming responses, execution tracking, and per-user API key management.
  - icon: "\U0001F3E2"
    title: Enterprise Ready
    details: Full admin dashboard, role-based access control with 15 granular permissions, user management, and application health monitoring.
  - icon: "\U0001F3A8"
    title: Modern UI
    details: 40+ Blade components built on the PenguinUI design system. Semantic tokens, 8 theme presets, and full dark mode support.
  - icon: "\U0001F4B3"
    title: Billing Integrated
    details: Feature-flagged Stripe payments with subscription plans, one-time products, checkout sessions, and billing portal.
  - icon: "\U0001F50D"
    title: Search & SEO
    details: Spotlight search with Cmd+K, SEO fields on every post, Open Graph support, and auto-generated API documentation.
  - icon: "\u26A1"
    title: Real-time
    details: WebSocket broadcasting via Laravel Reverb, database notifications, live toast alerts, and queued notification jobs.
---

## Tech Stack

Built with the **TALL stack** — Tailwind CSS 4, Alpine.js 3, Laravel 12, and Livewire 4.

| Technology | Role |
|---|---|
| **Laravel 12** | Backend framework |
| **Livewire 4** | Reactive server-side components |
| **Alpine.js 3** | Client-side interactivity |
| **Tailwind CSS 4** | Utility-first CSS |
| **PenguinUI** | Design system |
| **Pest 3** | Testing framework |

<style>
:root {
  --vp-home-hero-name-color: transparent;
  --vp-home-hero-name-background: linear-gradient(135deg, #6366f1 10%, #8b5cf6 40%, #f59e0b 80%);
  --vp-home-hero-image-background-image: linear-gradient(135deg, #6366f1 30%, #f59e0b 70%);
  --vp-home-hero-image-filter: blur(56px);
}

.dark {
  --vp-home-hero-image-background-image: linear-gradient(135deg, #818cf8 30%, #f59e0b 70%);
}
</style>
