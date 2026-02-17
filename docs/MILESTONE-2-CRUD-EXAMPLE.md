# Milestone 2: CRUD Example with Data Table

## Summary

Added a complete Posts CRUD resource demonstrating Livewire-based data management with search, filtering, sorting, pagination, and inline delete confirmation.

## What Was Added

### Model & Database
- **Post model** (`app/Models/Post.php`) — with `user` relationship, `isPublished()` helper, and factory support
- **Migration** — `posts` table with `user_id`, `title`, `body`, `status`, `published_at`, timestamps
- **PostFactory** — with `published()` and `draft()` states
- **DatabaseSeeder** — updated to seed 6 users with 20 posts total

### Livewire Components
| Component | Route | Features |
|-----------|-------|----------|
| `Posts\Index` | `/posts` | Table with search, status filter, sortable columns, pagination, delete with confirmation |
| `Posts\Create` | `/posts/create` | Form with title, body, status. Sets `published_at` automatically |
| `Posts\Edit` | `/posts/{post}/edit` | Pre-filled edit form with ownership check (403 if not owner) |

### Views
- `livewire/posts/index.blade.php` — Uses table, badge, empty-state, and modal components
- `livewire/posts/create.blade.php` — Uses breadcrumbs, textarea, select components
- `livewire/posts/edit.blade.php` — Same form with edit-specific labels

### Navigation
- Added "Posts" link to sidebar with `document-text` icon
- Active state highlights when on any `posts.*` route

### Routes Added
| Method | URI | Name |
|--------|-----|------|
| GET | `/posts` | `posts.index` |
| GET | `/posts/create` | `posts.create` |
| GET | `/posts/{post}/edit` | `posts.edit` |

### Features Demonstrated
- **URL-synced search** — `wire:model.live.debounce.300ms` with `#[Url]`
- **Status filtering** — dropdown filter persisted in URL
- **Sortable columns** — click column headers to sort asc/desc
- **Pagination** — 10 posts per page with Livewire pagination
- **Ownership scoping** — all queries filtered by `Auth::id()`
- **Delete confirmation** — modal with confirm/cancel flow
- **Toast notifications** — success messages on create/edit/delete
- **Breadcrumb navigation** — on create/edit pages

## Tests Added (17 new tests)

- `tests/Feature/Posts/PostsIndexTest.php` — 7 tests (render, auth, scoping, search, filter, delete, empty state)
- `tests/Feature/Posts/CreatePostTest.php` — 4 tests (render, create, published_at, validation)
- `tests/Feature/Posts/EditPostTest.php` — 4 tests (render, update, authorization, validation)
- `tests/Feature/Posts/PostModelTest.php` — 2 tests (relationship, isPublished)

**Total: 98 tests passing (233 assertions)**
