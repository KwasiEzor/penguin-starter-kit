<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Plan> */
class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomElement([999, 1999, 2999, 4999]),
            'stripe_price_id' => 'price_' . fake()->unique()->bothify('??????????'),
            'interval' => fake()->randomElement(['month', 'year']),
            'features' => [fake()->sentence(), fake()->sentence(), fake()->sentence()],
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
            'is_featured' => false,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
