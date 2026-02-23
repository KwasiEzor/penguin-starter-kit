<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a purchase order placed by a user for a product.
 *
 * Tracks Stripe checkout session and payment intent identifiers,
 * along with the order amount, currency, and status.
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string|null $stripe_checkout_session_id
 * @property string|null $stripe_payment_intent_id
 * @property int $amount
 * @property string $currency
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @property-read Product $product
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'amount',
        'currency',
        'status',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'integer',
        ];
    }

    /**
     * Get the user who placed this order.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with this order.
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order amount formatted as a dollar string (e.g., "$12.50").
     *
     * @return string The formatted price string
     */
    public function formattedAmount(): string
    {
        return '$'.number_format($this->amount / 100, 2);
    }
}
