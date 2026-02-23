<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * Represents an authenticated user of the application.
 *
 * Users can create posts, AI agents, manage API keys, place orders, and
 * subscribe to plans. Supports roles/permissions, media uploads (avatar),
 * Stripe billing, API tokens, and email verification.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AiAgent> $aiAgents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AiApiKey> $aiApiKeys
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AiExecution> $aiExecutions
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use InteractsWithMedia;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine whether the user has the admin role.
     *
     * @return bool True if the user is an administrator
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(RoleEnum::Admin);
    }

    /**
     * Get all orders placed by this user.
     *
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all blog posts authored by this user.
     *
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    /**
     * Get all AI agents created by this user.
     *
     * @return HasMany<AiAgent, $this>
     */
    public function aiAgents(): HasMany
    {
        return $this->hasMany(AiAgent::class);
    }

    /**
     * Get all AI API keys owned by this user.
     *
     * @return HasMany<AiApiKey, $this>
     */
    public function aiApiKeys(): HasMany
    {
        return $this->hasMany(AiApiKey::class);
    }

    /**
     * Get all AI executions initiated by this user.
     *
     * @return HasMany<AiExecution, $this>
     */
    public function aiExecutions(): HasMany
    {
        return $this->hasMany(AiExecution::class);
    }

    /**
     * Get the user's initials (up to 2 characters) from their name.
     *
     * @return string The uppercase initials derived from the user's name
     */
    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn (string $part) => strtoupper(substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    }

    /**
     * Register the media collections for this model.
     *
     * Defines a single-file "avatar" collection for the user's profile picture.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    /**
     * Get the URL of the user's avatar image, or null if none is set.
     *
     * @return string|null The avatar URL, or null if no avatar has been uploaded
     */
    public function avatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('avatar') ?: null;
    }
}
