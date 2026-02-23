<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a single execution (run) of an AI agent.
 *
 * Tracks the input, output, status, token usage, execution time, and any
 * errors that occurred during an AI agent's execution.
 *
 * @property int $id
 * @property int $ai_agent_id
 * @property int $user_id
 * @property string $input
 * @property string|null $output
 * @property string $status
 * @property int|null $tokens_input
 * @property int|null $tokens_output
 * @property int|null $execution_time_ms
 * @property string|null $error_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read AiAgent $agent
 * @property-read User $user
 */
class AiExecution extends Model
{
    protected $fillable = [
        'ai_agent_id',
        'user_id',
        'input',
        'output',
        'status',
        'tokens_input',
        'tokens_output',
        'execution_time_ms',
        'error_message',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tokens_input' => 'integer',
            'tokens_output' => 'integer',
            'execution_time_ms' => 'integer',
        ];
    }

    /**
     * Get the AI agent that performed this execution.
     *
     * @return BelongsTo<AiAgent, $this>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(AiAgent::class, 'ai_agent_id');
    }

    /**
     * Get the user who initiated this execution.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
