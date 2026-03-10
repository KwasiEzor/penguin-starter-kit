# Posts & Blog

A complete blog engine with rich content authoring.

## Features

- **Full CRUD** — create, read, update, and delete posts scoped to the authenticated user
- **Rich text editor** — Trix editor for composing post content with formatting, images, and attachments
- **Draft/Published status** with automatic `published_at` timestamp management
- **Auto-generated slugs** from post titles with unique suffix handling
- **Tag system** via Spatie Tags — comma-separated input, filter by tag
- **Category system** — polymorphic categories with admin CRUD, filter posts by category
- **Featured images** via Spatie Media Library with upload, replacement, and removal
- **SEO fields** — meta title, meta description, and excerpt per post
- **Data table** with search, status filter, tag filter, category filter, sortable columns, and pagination
- **Public blog** at `/blog/{slug}` with SEO meta tags and Open Graph image support
- **Authorization** via `PostPolicy` — owners manage their posts; users with elevated permissions can act on any post
- **Real-time notifications** — when a post is published, all other users are notified via database notification and WebSocket push

## Data Table Features

The posts index page includes a full-featured data table:

| Feature | Description |
|---|---|
| Search | Filter posts by title or body content |
| Status filter | Show all, drafts only, or published only |
| Tag filter | Filter by specific tag |
| Category filter | Filter by category |
| Sortable columns | Sort by title, status, or date |
| Pagination | Configurable page sizes |

## Authorization

The `PostPolicy` enforces access control:

- **View** — any authenticated user can view posts
- **Create** — users with `posts.create` permission
- **Edit** — post owner or users with `posts.edit` permission
- **Delete** — post owner or users with `posts.delete` permission
- **Publish** — users with `posts.publish` permission

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/posts` | `posts.index` | Posts list with filters |
| GET | `/posts/create` | `posts.create` | Create post form |
| GET | `/posts/{post}/edit` | `posts.edit` | Edit post form |
| GET | `/blog/{slug}` | `blog.show` | Public blog post |
