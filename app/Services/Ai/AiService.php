<?php

declare(strict_types=1);

namespace App\Services\Ai;

use App\Enums\AiProviderEnum;
use App\Models\AiAgent;
use App\Models\AiApiKey;
use App\Models\AiExecution;
use App\Models\User;
use RuntimeException;

use function Laravel\Ai\agent;

/**
 * Service for executing AI agent prompts and managing API key resolution.
 *
 * Handles the full lifecycle of an AI agent execution, including API key
 * resolution, provider configuration, prompt submission, and execution
 * record persistence.
 */
class AiService
{
    /**
     * Execute an AI agent with the given input on behalf of a user.
     *
     * Creates an execution record, resolves the appropriate API key, sends
     * the prompt to the configured AI provider, and updates the execution
     * record with the result or error.
     *
     * @param  AiAgent  $aiAgent  The AI agent to execute.
     * @param  string   $input    The user-provided prompt input.
     * @param  User     $user     The user initiating the execution.
     * @return AiExecution The refreshed execution record containing the result or error.
     */
    public function execute(AiAgent $aiAgent, string $input, User $user): AiExecution
    {
        $execution = AiExecution::create([
            'ai_agent_id' => $aiAgent->id,
            'user_id' => $user->id,
            'input' => $input,
            'status' => 'running',
        ]);

        try {
            $provider = $aiAgent->providerEnum();
            $resolvedKey = $this->resolveApiKey($provider, $user);

            config([sprintf('ai.providers.%s.key', $provider->configKey()) => $resolvedKey]);

            $startTime = microtime(true);

            $response = agent(
                instructions: $aiAgent->system_prompt,
            )->prompt(
                $input,
                provider: $provider->configKey(),
                model: $aiAgent->model,
            );

            $executionTimeMs = (int) round((microtime(true) - $startTime) * 1000);

            $execution->update([
                'output' => $response->text,
                'status' => 'completed',
                'tokens_input' => $response->usage->promptTokens,
                'tokens_output' => $response->usage->completionTokens,
                'execution_time_ms' => $executionTimeMs,
            ]);
        } catch (\Throwable $throwable) {
            $execution->update([
                'status' => 'failed',
                'error_message' => $throwable->getMessage(),
            ]);
        }

        return $execution->refresh();
    }

    /**
     * Resolve the API key for a given AI provider and user.
     *
     * Attempts to find an active user-specific key first, then falls back
     * to a global key. Throws an exception if no key is configured.
     *
     * @param  AiProviderEnum  $provider  The AI provider to resolve a key for.
     * @param  User            $user      The user whose personal key should be checked first.
     * @return string The decrypted API key.
     *
     * @throws RuntimeException If no active API key is found for the provider.
     */
    public function resolveApiKey(AiProviderEnum $provider, User $user): string
    {
        $userKey = AiApiKey::where('user_id', $user->id)
            ->forProvider($provider)
            ->where('is_active', true)
            ->first();

        if ($userKey instanceof AiApiKey) {
            return $userKey->getDecryptedKey();
        }

        $globalKey = AiApiKey::global()
            ->forProvider($provider)
            ->where('is_active', true)
            ->first();

        if ($globalKey instanceof AiApiKey) {
            return $globalKey->getDecryptedKey();
        }

        throw new RuntimeException(sprintf('No API key configured for %s. Please configure a key in settings.', $provider->label()));
    }
}
