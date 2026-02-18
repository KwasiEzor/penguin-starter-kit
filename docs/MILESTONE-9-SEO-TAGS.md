# Milestone 9: Post SEO & Tags

## Overview

This milestone adds a comprehensive SEO layer and tagging system to posts using `spatie/laravel-tags`. Posts now have slugs for clean URLs, excerpts, meta titles/descriptions, and tags. A public-facing blog view with Open Graph/Twitter meta tags is also included.

## Features

### Tags (spatie/laravel-tags)
- Comma-separated tag input on Create/Edit post forms
- Tags displayed as badges on the posts index
- Tag filter dropdown on the posts index
- Tags synced via `$post->syncTags()` / `$post->attachTags()`
- Tags auto-created if they don't exist

### SEO Fields
- **Slug**: Auto-generated from title, unique, editable
- **Excerpt**: Optional summary, auto-generated from body if empty
- **Meta Title**: Max 60 characters, with live character count
- **Meta Description**: Max 160 characters, with live character count
- Collapsible "SEO Settings" section in Create/Edit forms

### Public Blog
- Route: `GET /blog/{slug}` — no authentication required
- Only shows published posts (draft returns 404)
- Standalone blog layout with minimal navigation
- Open Graph and Twitter Card meta tags in `<head>`

### API Updates
- SEO fields (slug, excerpt, meta_title, meta_description) in store/update
- Tags array in store/update via `$post->syncTags()`
- Tags eager-loaded in index, show, and mutation responses

## Technical Details

### New Dependencies
- `spatie/laravel-tags` ^4.10

### Database Changes
- `tags` table (via spatie migration)
- `taggables` pivot table (via spatie migration)
- `posts` table: added `slug` (unique), `excerpt` (nullable text), `meta_title` (nullable string 255), `meta_description` (nullable string 255)

### New Files
| File | Purpose |
|------|---------|
| `database/migrations/..._add_seo_fields_to_posts_table.php` | SEO columns on posts |
| `app/Livewire/Blog/Show.php` | Public blog post page |
| `resources/views/livewire/blog/show.blade.php` | Blog post view with OG meta |
| `resources/views/components/layouts/blog.blade.php` | Minimal blog layout |
| `tests/Feature/Posts/PostSeoTest.php` | 8 tests for SEO fields |
| `tests/Feature/Posts/TagTest.php` | 6 tests for tagging |
| `tests/Feature/Blog/BlogShowTest.php` | 6 tests for public blog |

### Modified Files
| File | Change |
|------|--------|
| `app/Models/Post.php` | `HasTags` trait, SEO fields, slug auto-generation, `getExcerpt()` |
| `database/factories/PostFactory.php` | slug + excerpt in definition |
| `database/seeders/DatabaseSeeder.php` | Attach random tags to seeded posts |
| `app/Livewire/Posts/Create.php` | SEO fields, tags_input, auto-slug |
| `app/Livewire/Posts/Edit.php` | SEO fields, tags_input pre-fill, sync |
| `resources/views/livewire/posts/create.blade.php` | Tags input + SEO section |
| `resources/views/livewire/posts/edit.blade.php` | Tags input + SEO section |
| `app/Livewire/Posts/Index.php` | Tag filter, eager-load tags |
| `resources/views/livewire/posts/index.blade.php` | Tag badges + tag filter |
| `resources/views/partials/head.blade.php` | `@stack('meta')` |
| `routes/web.php` | `/blog/{slug}` route |
| `app/Http/Controllers/Api/PostController.php` | SEO fields + tags in API |

## Test Coverage
- **193 total tests passing** (20 new + 173 existing)
- PostSeoTest: slug generation, uniqueness, SEO fields CRUD, excerpt, validation
- TagTest: create/sync/remove tags, filter by tag, display badges
- BlogShowTest: published/draft/404, OG meta tags, public access
