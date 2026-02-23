<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Represents a subscription plan available for purchase.
 *
 * Each plan has a Stripe price ID for payment processing, a set of features,
 * and can be marked as active or featured. A slug is auto-generated on creation.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $price
 * @property string|null $stripe_price_id
 * @property string $interval
 * @property array<int, string>|null $features
 * @property int $sort_order
 * @property bool $is_active
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stripe_price_id',
        'interval',
        'features',
        'sort_order',
        'is_active',
        'is_featured',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'features' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Boot the model and register event listeners.
     *
     * Automatically generates a slug from the name when creating a plan
     * if no slug has been provided.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Plan $plan): void {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

    /**
     * Get the plan price formatted as a dollar string (e.g., "$9.99").
     *
     * @return string The formatted price string
     */
    public function formattedPrice(): string
    {
        return '$'.number_format($this->price / 100, 2);
    }
}
