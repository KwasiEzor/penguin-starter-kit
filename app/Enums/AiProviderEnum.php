<?php

declare(strict_types=1);

namespace App\Enums;

use Laravel\Ai\Enums\Lab;

/**
 * Supported AI service providers.
 *
 * Defines the available AI providers that can be used for AI agent executions,
 * along with their supported models and configuration mappings.
 *
 * @case OpenAi   - OpenAI provider (GPT models)
 * @case Anthropic - Anthropic provider (Claude models)
 * @case Gemini   - Google Gemini provider (Gemini models)
 */
enum AiProviderEnum: string
{
    /** OpenAI provider supporting GPT-4o and GPT-4 Turbo models. */
    case OpenAi = 'openai';

    /** Anthropic provider supporting Claude Sonnet and Haiku models. */
    case Anthropic = 'anthropic';

    /** Google Gemini provider supporting Gemini 2.0 Flash and 1.5 models. */
    case Gemini = 'gemini';

    /**
     * Get the human-readable display label for this provider.
     *
     * @return string The formatted provider name
     */
    public function label(): string
    {
        return match ($this) {
            self::OpenAi => 'OpenAI',
            self::Anthropic => 'Anthropic',
            self::Gemini => 'Gemini',
        };
    }

    /**
     * @return list<string>
     */
    public function models(): array
    {
        return match ($this) {
            self::OpenAi => ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo'],
            self::Anthropic => ['claude-sonnet-4-5-20250929', 'claude-haiku-4-5-20251001'],
            self::Gemini => ['gemini-2.0-flash', 'gemini-1.5-pro', 'gemini-1.5-flash'],
        };
    }

    public function defaultModel(): string
    {
        return $this->models()[0];
    }

    public function toLab(): Lab
    {
        return match ($this) {
            self::OpenAi => Lab::OpenAI,
            self::Anthropic => Lab::Anthropic,
            self::Gemini => Lab::Gemini,
        };
    }

    public function configKey(): string
    {
        return match ($this) {
            self::OpenAi => 'openai',
            self::Anthropic => 'anthropic',
            self::Gemini => 'gemini',
        };
    }
}
