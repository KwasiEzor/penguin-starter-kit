# 🗺️ Penguin Starter Kit Roadmap

This roadmap outlines the planned improvements to elevate the starter kit into a premium, production-ready SaaS foundation.

## Phase 1: Developer Experience & Observability (The "Polish")
*Focus: Making the kit easy to document, monitor, and deploy.*

- [x] **Automated API Documentation**
    - **Tool:** `dedoc/scramble` (Zero-config OpenAPI generation).
    - **Goal:** auto-generate interactive API docs for the Sanctum endpoints at `/docs/api`.
    - **Status:** Completed. Access at `/docs/api`.

- [x] **System Health Monitoring**
    - **Tool:** `spatie/laravel-health`.
    - **Goal:** Add a status page checking Database, Redis, Reverb, Disk Space, and Debug Mode.
    - **Status:** Completed. Admin access at `/admin/health`.

- [ ] **Production Infrastructure**
    - **Deliverable:** Production-optimized `Dockerfile` and `docker-compose.prod.yml`.
    - **Why:** Reduces "works on my machine" issues and speeds up deployment to Fly.io/AWS/DigitalOcean.

## Phase 2: SaaS Analytics & Insights (The "Value")
*Focus: Making the Admin Dashboard feel alive and valuable.*

- [x] **Interactive Analytics Charts**
    - **Tool:** ApexCharts.
    - **Features:** User Growth and AI Token Usage (last 30 days).
    - **Status:** Completed. Viewable on the Admin Dashboard.

- [ ] **Global Search Improvements**
    - **Feature:** Add "Jump to User" and "Jump to Settings" to the Spotlight search.
    - **Why:** Power users live in the command palette.

## Phase 3: AI Ecosystem Enhancements (The "Specialty")
*Focus: Showcasing the power of the AI Agent system.*

- [x] **Pre-built Agent Templates**
    - **Action:** Seeded 3 high-quality agents (Copy Editor, SEO Wizard, Code Architect).
    - **Status:** Completed. Viewable in the "Agents" section.

- [ ] **Streaming Responses**
    - **Feature:** Ensure AI responses stream token-by-token using Livewire streaming.
    - **Why:** Waiting 5 seconds for a full text block feels slow; streaming feels instant.

## Phase 4: Multi-Tenancy (Optional / Major Feature)
- [ ] **Team Support**
    - **Feature:** Allow Users to create/join Teams.
    - **Scope:** Update `Post` and `AiAgent` models to belong to `Team` instead of `User`.
    - **Note:** This is a high-effort change that fundamentally alters the kit's architecture.

---

## 🚦 Priority Selection

Recommended starting point: **Phase 1 (Docs & Health)** or **Phase 2 (Analytics)** as they provide the most visible "premium" upgrade with the least friction.
