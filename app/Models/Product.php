<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Represents a purchasable product in the store.
 *
 * Each product has a Stripe price ID for payment processing and can be
 * toggled active/inactive. A slug is auto-generated from the name on creation.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $price
 * @property string|null $stripe_price_id
 * @property bool $is_active
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stripe_price_id',
        'is_active',
        'sort_order',
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
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Boot the model and register event listeners.
     *
     * Automatically generates a slug from the name when creating a product
     * if no slug has been provided.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product): void {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the product price formatted as a dollar string (e.g., "$19.99").
     *
     * @return string The formatted price string
     */
    public function formattedPrice(): string
    {
        return '$'.number_format($this->price / 100, 2);
    }
}
