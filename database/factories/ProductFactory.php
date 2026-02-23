<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating Product test data.
 *
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /** @var class-string<Product> The model class that this factory creates. */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attribute values for a Product.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomElement([999, 1999, 4999, 9999]),
            'stripe_price_id' => 'price_'.fake()->unique()->bothify('??????????'),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * Indicate that the product should be inactive.
     *
     * @return static The factory instance with inactive state applied.
     */
    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
