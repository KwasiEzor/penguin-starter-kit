<?php

namespace Database\Factories;

use App\Enums\AiProviderEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating AiAgent test data.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AiAgent>
 */
class AiAgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attribute values for an AiAgent.
     */
    public function definition(): array
    {
        $provider = fake()->randomElement(AiProviderEnum::cases());

        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true).' Agent',
            'description' => fake()->sentence(),
            'provider' => $provider->value,
            'model' => $provider->defaultModel(),
            'system_prompt' => fake()->paragraph(),
            'temperature' => fake()->randomFloat(2, 0, 2),
            'max_tokens' => fake()->randomElement([256, 512, 1024, 2048]),
            'is_active' => true,
            'is_public' => false,
        ];
    }

    /**
     * Indicate that the AI agent should be publicly accessible.
     *
     * @return static The factory instance with public state applied.
     */
    public function public(): static
    {
        return $this->state(fn (): array => [
            'is_public' => true,
        ]);
    }

    /**
     * Indicate that the AI agent should be inactive.
     *
     * @return static The factory instance with inactive state applied.
     */
    public function inactive(): static
    {
        return $this->state(fn (): array => [
            'is_active' => false,
        ]);
    }

    /**
     * Set the AI agent to use a specific AI provider and its default model.
     *
     * @param  AiProviderEnum  $provider  The AI provider to assign to the agent.
     * @return static The factory instance with the specified provider state applied.
     */
    public function forProvider(AiProviderEnum $provider): static
    {
        return $this->state(fn (): array => [
            'provider' => $provider->value,
            'model' => $provider->defaultModel(),
        ]);
    }
}
