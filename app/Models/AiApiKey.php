<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AiProviderEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

/**
 * Represents an encrypted API key for an AI provider.
 *
 * API keys can be owned by a specific user or be global (user_id is null).
 * The actual key value is encrypted at rest and hidden from serialization.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $provider
 * @property string $api_key
 * @property string|null $label
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 */
class AiApiKey extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'api_key',
        'label',
        'is_active',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'api_key',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the accessor/mutator for the api_key attribute that encrypts on set.
     *
     * @return Attribute<string, string>
     */
    protected function apiKey(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => Crypt::encryptString($value),
        );
    }

    /**
     * Decrypt and return the raw API key value.
     *
     * @return string The decrypted API key
     */
    public function getDecryptedKey(): string
    {
        return Crypt::decryptString($this->attributes['api_key']);
    }

    /**
     * Get the user who owns this API key.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope the query to keys for a specific AI provider.
     *
     * @param  Builder<self>  $query
     * @param  AiProviderEnum  $provider  The AI provider to filter by
     * @return Builder<self>
     */
    public function scopeForProvider(Builder $query, AiProviderEnum $provider): Builder
    {
        return $query->where('provider', $provider->value);
    }

    /**
     * Scope the query to only include global (non-user-specific) API keys.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeGlobal(Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }
}
