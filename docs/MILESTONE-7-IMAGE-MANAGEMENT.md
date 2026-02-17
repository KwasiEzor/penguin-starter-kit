# Milestone 7: Image Management with Spatie Media Library

## Summary

Added image management using Spatie Media Library, covering user avatars and post featured images. Includes a reusable drag-and-drop file upload component, avatar display across the app (sidebar, mobile header, admin dashboard), and featured image thumbnails in the posts table.

## What Was Added

### Spatie Media Library Integration
- Installed `spatie/laravel-medialibrary` package
- Published and ran the `media` table migration
- Created storage symlink for public file access

### User Avatars
- **User Model** (`app/Models/User.php`)
  - Added `HasMedia` interface and `InteractsWithMedia` trait
  - Registered `avatar` media collection (single file)
  - Added `avatarUrl()` helper method
- **Profile Settings** (`app/Livewire/Settings/Profile.php`)
  - Upload avatar via `WithFileUploads` (auto-saves on file selection)
  - Remove avatar action
  - Validation: image file, max 2MB
- **Profile View** — avatar preview with upload button, remove link when avatar exists

### Post Featured Images
- **Post Model** (`app/Models/Post.php`)
  - Added `HasMedia` interface and `InteractsWithMedia` trait
  - Registered `featured_image` media collection (single file)
  - Added `featuredImageUrl()` helper method
- **Create Post** — optional featured image upload with drag-and-drop
- **Edit Post** — upload new image, preview existing, remove button
- **Posts Index** — thumbnail column showing featured image or placeholder icon

### Reusable File Upload Component
- **`x-file-upload`** (`resources/views/components/file-upload.blade.php`)
  - Drag-and-drop zone with upload icon
  - Image preview mode with optional remove button
  - Configurable: `wire`, `accept`, `label`, `hint`, `preview`, `removable`, `removeAction`
  - Styled with PenguinUI design tokens

### UI Updates
- **Sidebar** — uses `<x-avatar>` with `avatarUrl()` for logged-in user
- **Mobile Header** — uses `<x-avatar>` with `avatarUrl()` for dropdown trigger
- **Admin Dashboard** — recent users list shows real avatars

## Files Modified

| File | Change |
|------|--------|
| `composer.json` | Added `spatie/laravel-medialibrary` |
| `app/Models/User.php` | HasMedia, InteractsWithMedia, avatar collection |
| `app/Models/Post.php` | HasMedia, InteractsWithMedia, featured_image collection |
| `app/Livewire/Settings/Profile.php` | Avatar upload/remove with WithFileUploads |
| `app/Livewire/Posts/Create.php` | Featured image upload with WithFileUploads |
| `app/Livewire/Posts/Edit.php` | Featured image upload/remove with WithFileUploads |
| `resources/views/livewire/settings/profile.blade.php` | Avatar upload UI |
| `resources/views/livewire/posts/create.blade.php` | Featured image upload area |
| `resources/views/livewire/posts/edit.blade.php` | Featured image upload/preview/remove |
| `resources/views/livewire/posts/index.blade.php` | Thumbnail column |
| `resources/views/components/sidebar.blade.php` | Avatar in user dropdown |
| `resources/views/components/layouts/app/sidebar.blade.php` | Avatar in mobile header |
| `resources/views/livewire/admin/dashboard.blade.php` | Avatar in recent users |

## Files Created

| File | Purpose |
|------|---------|
| `resources/views/components/file-upload.blade.php` | Reusable drag & drop upload component |
| `tests/Feature/Settings/AvatarTest.php` | Avatar upload/remove tests |
| `tests/Feature/Posts/FeaturedImageTest.php` | Post featured image tests |
| `tests/Feature/Components/FileUploadTest.php` | File upload component render tests |
| `docs/MILESTONE-7-IMAGE-MANAGEMENT.md` | This document |

## Tests Added

- `tests/Feature/Settings/AvatarTest.php` (4 tests)
  - Uploads an avatar
  - Validates avatar is an image
  - Validates avatar max size
  - Removes an avatar
- `tests/Feature/Posts/FeaturedImageTest.php` (4 tests)
  - Creates post with featured image
  - Uploads featured image on edit
  - Removes a featured image
  - Validates featured image is an image file
- `tests/Feature/Components/FileUploadTest.php` (4 tests)
  - Renders with default label
  - Renders with custom label and hint
  - Renders preview image
  - Renders remove button when removable
