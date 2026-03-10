# Spotlight Search

## Features

- **Cmd+K / Ctrl+K** opens a search overlay from anywhere in the app
- **Post search** — queries the user's posts by title or body (top 5 results)
- **Page search** — filters navigation pages (Dashboard, Posts, Create Post, Settings)
- Closes on Escape or click outside

## How It Works

The spotlight search is a Livewire component that provides instant search across two categories:

### Post Results

Searches your posts by title and body content, returning the top 5 matches. Click a result to navigate directly to the post edit page.

### Page Results

Searches navigation pages by name, providing quick access to:

- Dashboard
- Posts
- Create Post
- Settings

## Keyboard Shortcuts

| Shortcut | Action |
|---|---|
| `Cmd+K` / `Ctrl+K` | Open search overlay |
| `Escape` | Close search overlay |
| `Enter` | Navigate to selected result |
| `Arrow Up/Down` | Navigate between results |
