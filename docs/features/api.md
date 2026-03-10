# REST API

RESTful API with automatic documentation, powered by Laravel Sanctum.

## Features

- **Sanctum-authenticated** REST API for posts (`/api/posts`)
- **Full CRUD** — list (with `?status=` filter), create (with tags array), show, update, delete
- **Form Request validation** — dedicated `StorePostRequest` and `UpdatePostRequest` classes
- **API Resources** — `PostResource` and `UserResource` for consistent JSON output
- **Token management UI** in settings — create named tokens, view existing tokens, revoke tokens
- **Interactive API documentation** at `/docs/api` powered by [Scramble](https://scramble.dedoc.co/) with Bearer auth
- **Rate limiting** — 60 requests per minute per user/IP

## Endpoints

| Method | URI | Description |
|---|---|---|
| GET | `/api/user` | Authenticated user info |
| GET | `/api/posts` | List own posts (supports `?status=` filter) |
| POST | `/api/posts` | Create post |
| GET | `/api/posts/{post}` | Show post |
| PUT/PATCH | `/api/posts/{post}` | Update post |
| DELETE | `/api/posts/{post}` | Delete post |

## Authentication

The API uses Bearer token authentication via Laravel Sanctum.

### Creating Tokens

Tokens can be created from **Settings > API Tokens** in the web UI, or programmatically:

```php
$token = $user->createToken('my-app-token');
$plainTextToken = $token->plainTextToken;
```

### Using Tokens

Include the token in the `Authorization` header:

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
     https://your-app.com/api/posts
```

## Rate Limiting

| Route Group | Max Requests | Window |
|---|---|---|
| API (`/api/*`) | 60 | 1 minute |

## API Documentation

Interactive API documentation is available at `/docs/api`, powered by Scramble. It provides:

- Auto-generated endpoint documentation
- Request/response schemas
- Bearer auth testing
- Try-it-out functionality
