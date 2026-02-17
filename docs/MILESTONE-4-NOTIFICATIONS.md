# Milestone 4: Notification System with UI

## Summary

Added a database-backed notification system with a bell icon dropdown in the sidebar, mark-as-read functionality, and automatic notifications when posts are published.

## What Was Added

### Database
- **Migration** — standard Laravel `notifications` table (uuid, type, morphs, data, read_at, timestamps)

### Notification Class
- **PostPublished** (`app/Notifications/PostPublished.php`) — database channel notification with post title and message

### Notification Center Livewire Component
- **NotificationCenter** (`app/Livewire/NotificationCenter.php`)
  - Displays last 10 notifications in a dropdown
  - Shows unread count badge (caps at 9+)
  - `markAsRead(id)` — marks individual notification as read
  - `markAllAsRead()` — marks all as read
  - Empty state when no notifications

### UI Integration
- Bell icon added to sidebar (above user dropdown)
- Unread count badge with danger color
- Dropdown with notification list, timestamps, and read/mark-all actions
- Unread notifications highlighted with primary background

### Auto-Trigger
- Publishing a post via `Posts\Create` sends a `PostPublished` notification to the author
- Draft posts do not trigger notifications

## Tests Added (7 new tests)

- `tests/Feature/NotificationCenterTest.php`
  - Renders notification center
  - Shows unread count
  - Marks individual notification as read
  - Marks all as read
  - Shows empty state
  - Sends notification on publish
  - Skips notification for drafts

**Total: 117 tests passing (255 assertions)**
