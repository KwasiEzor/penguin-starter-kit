<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'stripe_checkout_session_id' => 'cs_' . fake()->unique()->bothify('??????????'),
            'stripe_payment_intent_id' => 'pi_' . fake()->unique()->bothify('??????????'),
            'amount' => fake()->randomElement([999, 1999, 4999, 9999]),
            'currency' => 'usd',
            'status' => 'completed',
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function failed(): static
    {
        return $this->state(['status' => 'failed']);
    }
}
