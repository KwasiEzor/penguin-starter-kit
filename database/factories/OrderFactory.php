<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating Order test data.
 *
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /** @var class-string<Order> The model class that this factory creates. */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attribute values for an Order.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'stripe_checkout_session_id' => 'cs_'.fake()->unique()->bothify('??????????'),
            'stripe_payment_intent_id' => 'pi_'.fake()->unique()->bothify('??????????'),
            'amount' => fake()->randomElement([999, 1999, 4999, 9999]),
            'currency' => 'usd',
            'status' => 'completed',
        ];
    }

    /**
     * Indicate that the order should have a pending status.
     *
     * @return static The factory instance with pending state applied.
     */
    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    /**
     * Indicate that the order should have a failed status.
     *
     * @return static The factory instance with failed state applied.
     */
    public function failed(): static
    {
        return $this->state(['status' => 'failed']);
    }
}
