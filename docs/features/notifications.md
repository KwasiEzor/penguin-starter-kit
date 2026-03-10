# Notifications & Real-time

## Features

- **Database notifications** — when a post is published, all other users receive a notification via a queued job
- **Real-time push** via Laravel Reverb WebSockets on private per-user channels
- **Notification center** in the sidebar — bell icon with unread count, last 10 notifications, mark as read
- **Instant toast** on push — new post notifications appear as a toast without a page refresh

## How It Works

1. A user publishes a post
2. The `NewPostPublished` event fires
3. The `NotifyUsersOfNewPost` job is dispatched to the queue
4. Each user receives a `PostPublished` database notification
5. The notification is also broadcast via WebSocket to the user's private channel
6. The sidebar notification center updates in real-time
7. A toast notification appears instantly

## Configuration

Real-time broadcasting requires Laravel Reverb:

```ini
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_APP_ID=your-app-id
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

Start the WebSocket server:

```bash
php artisan reverb:start
```

::: tip
Use `composer dev` to start all services at once, including the Reverb WebSocket server and queue worker.
:::

## Architecture

- **Private channels** — each user has their own private channel, ensuring notifications reach only intended recipients
- **Queued jobs** — notification dispatch is queued to avoid blocking the publishing action
- **Database storage** — notifications persist in the database for the notification center
