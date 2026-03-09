# Penguin Starter Kit - Technical Audit Report

This report summarizes the findings from a comprehensive code review and architectural analysis.

## 🔴 Critical Bugs (Functional Failures)

1.  **Checkout Redirection Failure:**
    *   **File:** `app/Livewire/Pricing.php`
    *   **Issue:** The `subscribe` and `purchase` methods return a Stripe Checkout URL as a string but do not execute a redirect. The UI remains static after clicking "Subscribe" or "Buy Now."
    *   **Impact:** Payments are completely broken in the UI.

2.  **Broken Slug Auto-Generation:**
    *   **File:** `app/Livewire/Posts/Create.php`
    *   **Issue:** The `$previousAutoSlug` property is `private` and not persisted across Livewire requests. This causes the slug to stop updating automatically after the first character is typed.
    *   **Impact:** Poor DX and UX when creating posts.

3.  **Spotlight Search HTML Noise:**
    *   **File:** `app/Livewire/SpotlightSearch.php`
    *   **Issue:** Searching the `body` column hits raw HTML (Trix content). Queries for common tags like "div" or "href" return every post.
    *   **Impact:** Irrelevant search results.

## 🔒 Security Vulnerabilities

1.  **Stored XSS Risk:**
    *   **File:** `app/Livewire/Admin/WebsiteSettings.php`
    *   **Issue:** Custom script fields (`custom_scripts_header`, `custom_scripts_footer`) are saved without sanitization or restricted authorization.
    *   **Impact:** High-risk vulnerability allowing any admin to inject malicious JS into every page.

2.  **Plain-Text Social Secrets:**
    *   **File:** `app/Livewire/Admin/AuthSettings.php`
    *   **Issue:** Social Auth secrets (Google, GitHub, Facebook) are stored in plain text, unlike Stripe and AI keys which are encrypted.
    *   **Impact:** Exposure of sensitive credentials in the database.

3.  **AI Key Leakage (Octane/Swoole):**
    *   **File:** `app/Services/Ai/AiService.php`
    *   **Issue:** Uses global `config()` to swap API keys at runtime.
    *   **Impact:** Thread-unsafe in concurrent environments; one user's request could use another user's API key.

## 🚀 Scalability & Performance

1.  **Notification "Death-by-Memory":**
    *   **Files:** `app/Livewire/Posts/Create.php`, `app/Livewire/Posts/Edit.php`
    *   **Issue:** `User::where('id', '!=', Auth::id())->get()` loads all users into memory to send notifications.
    *   **Impact:** Will crash (OOM) once the user base grows.

2.  **Broadcasting Overload:**
    *   **File:** `app/Events/NewPostPublished.php`
    *   **Issue:** Returns thousands of private channels (one per user).
    *   **Impact:** Overwhelms the WebSocket server (Reverb) on every post publication.

3.  **Missing Database Indexes:**
    *   **Table:** `posts`
    *   **Issue:** No index on the `status` column despite heavy filtering.
    *   **Impact:** Slow queries on large datasets.

## 🟡 UX & Architectural Improvements

1.  **Orphaned Branding Files:**
    *   **File:** `app/Livewire/Admin/WebsiteSettings.php`
    *   **Issue:** New branding uploads don't delete old files from storage.
    *   **Impact:** Storage bloat.

2.  **Rigid API Validation:**
    *   **File:** `app/Http/Controllers/Api/PostController.php`
    *   **Issue:** `update()` requires `title` and `body` even for partial updates.
    *   **Impact:** Poor API design.

3.  **Invisible Secrets in UI:**
    *   **File:** `app/Livewire/Admin/Payments/Settings.php` (and others)
    *   **Issue:** Sensitive fields appear empty even if stored.
    *   **Impact:** Users unknowingly overwrite active keys.
