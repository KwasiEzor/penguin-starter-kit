<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AiProviderEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents an AI agent configured by a user to perform automated tasks.
 *
 * Each agent is associated with a specific AI provider and model, and can be
 * configured with custom system prompts, temperature, and token limits.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property string $provider
 * @property string $model
 * @property string|null $system_prompt
 * @property string $temperature
 * @property int $max_tokens
 * @property bool $is_active
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AiExecution> $executions
 */
class AiAgent extends Model
{
    /** @use HasFactory<\Database\Factories\AiAgentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'provider',
        'model',
        'system_prompt',
        'temperature',
        'max_tokens',
        'is_active',
        'is_public',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'temperature' => 'decimal:2',
            'max_tokens' => 'integer',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get the user who owns this AI agent.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all executions performed by this AI agent.
     *
     * @return HasMany<AiExecution, $this>
     */
    public function executions(): HasMany
    {
        return $this->hasMany(AiExecution::class);
    }

    /**
     * Get the provider as an AiProviderEnum instance.
     *
     * @return AiProviderEnum The enum representation of the agent's AI provider
     */
    public function providerEnum(): AiProviderEnum
    {
        return AiProviderEnum::from($this->provider);
    }

    /**
     * Scope the query to agents accessible by the given user (owned or public).
     *
     * @param  Builder<self>  $query
     * @param  User  $user  The user to check accessibility for
     * @return Builder<self>
     */
    public function scopeAccessibleBy(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $q) use ($user): void {
            $q->where('user_id', $user->id)
                ->orWhere('is_public', true);
        });
    }

    /**
     * Scope the query to only include active agents.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
