# AI Agents

A multi-provider AI agent system built on [Laravel AI](https://github.com/laravel/ai).

## Features

- **Full CRUD** — create, edit, and delete AI agents with name, description, system prompt, and model configuration
- **Multi-provider support** — OpenAI (GPT-4o, GPT-4o Mini, GPT-4 Turbo), Anthropic (Claude Sonnet 4.5, Claude Haiku 4.5), and Gemini (2.0 Flash, 1.5 Pro, 1.5 Flash)
- **Streaming responses** — real-time token-by-token output streaming
- **Execution tracking** — each agent run creates an `AiExecution` record with input, output, token usage, and execution time
- **API key management** — per-user personal API keys and admin-configured global fallback keys, all encrypted at rest
- **Layered key resolution** — user keys take priority over global keys
- **Visibility controls** — public agents visible to all users, private agents restricted to their owner
- **Authorization** via `AiAgentPolicy` — owners manage their agents; admins can manage any agent

## Supported Providers

| Provider | Models |
|---|---|
| **OpenAI** | GPT-4o, GPT-4o Mini, GPT-4 Turbo |
| **Anthropic** | Claude Sonnet 4.5, Claude Haiku 4.5 |
| **Gemini** | 2.0 Flash, 1.5 Pro, 1.5 Flash |

## Pre-seeded Templates

Three agent templates are included in the database seeder:

1. **Professional Copy Editor** — proofreading and content improvement
2. **SEO Content Wizard** — SEO-optimized content generation
3. **Code Architect** — code review and architecture advice

## API Key Resolution

Keys are resolved in order of priority:

1. **Per-user keys** — configured in Settings > AI API Keys
2. **Global keys** — configured by admin in Admin > AI Settings
3. **Environment keys** — from `.env` file (`OPENAI_API_KEY`, etc.)

All keys are encrypted at rest using Laravel's `Crypt::encryptString()`.

## Routes

| Method | URI | Name | Description |
|---|---|---|---|
| GET | `/agents` | `agents.index` | AI agents list |
| GET | `/agents/create` | `agents.create` | Create AI agent form |
| GET | `/agents/{aiAgent}` | `agents.show` | Agent detail and execution |
| GET | `/agents/{aiAgent}/edit` | `agents.edit` | Edit AI agent form |

## Admin Settings

Admins can manage AI features from **Admin > AI Settings**:

- Toggle AI features on/off globally
- Manage global API keys for OpenAI, Anthropic, and Gemini
- All keys encrypted at rest
