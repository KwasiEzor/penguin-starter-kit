# Quick Start

## Installation via Packagist (Recommended)

```bash
composer create-project kwasiezor/penguin-starter-kit my-app
```

This automatically:
1. Downloads the latest stable version
2. Installs all PHP dependencies
3. Creates your `.env` file and generates an app key
4. Sets up a local SQLite database and runs migrations

Then start the development server:

```bash
cd my-app
npm install && npm run dev    # Terminal 1: Vite dev server
php artisan serve             # Terminal 2: Laravel server
```

Visit `http://localhost:8000` and register your first account.

## Manual Installation

```bash
git clone https://github.com/kwasiezor/penguin-starter-kit.git my-app
cd my-app
composer setup    # install deps, generate key, run migrations
npm run dev       # start Vite
```

## One-Command Development

Start all services (server, queue, logs, Vite, Reverb) simultaneously:

```bash
composer dev
```

This runs Laravel server, queue worker, Pail log viewer, Vite, and Reverb WebSocket server in parallel with color-coded output.

## Default Test User

After seeding the database, you can log in with:

```
Email: test@example.com
Password: password
```

Run the seeder:

```bash
php artisan db:seed
```

This creates:
- 3 roles (Administrator, Editor, User) with 15 permissions
- 3 AI agent templates (Copy Editor, SEO Wizard, Code Architect)
- 6 default categories (Technology, Tutorial, News, Opinion, Review, Guide)
- 1 test user with administrator access

## Requirements

- **PHP** 8.4 or higher
- **Composer** 2.x
- **Node.js** 18+ and npm
- **SQLite** (default) or MySQL/PostgreSQL

## What's Next

- [Configuration](/guide/configuration) — set up environment variables and database
- [Project Structure](/guide/project-structure) — understand the codebase layout
- [Customization](/guide/customization) — make it your own
