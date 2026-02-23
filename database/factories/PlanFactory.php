<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating Plan test data.
 *
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /** @var class-string<Plan> The model class that this factory creates. */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attribute values for a Plan.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomElement([999, 1999, 2999, 4999]),
            'stripe_price_id' => 'price_'.fake()->unique()->bothify('??????????'),
            'interval' => fake()->randomElement(['month', 'year']),
            'features' => [fake()->sentence(), fake()->sentence(), fake()->sentence()],
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
            'is_featured' => false,
        ];
    }

    /**
     * Indicate that the plan should be inactive.
     *
     * @return static The factory instance with inactive state applied.
     */
    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }

    /**
     * Indicate that the plan should be marked as featured.
     *
     * @return static The factory instance with featured state applied.
     */
    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
