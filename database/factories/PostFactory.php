<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory for generating Post test data.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> The default attribute values for a Post.
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(5),
            'body' => fake()->paragraphs(3, true),
            'excerpt' => fake()->sentences(2, true),
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->optional(0.5)->dateTimeBetween('-1 year'),
        ];
    }

    /**
     * Indicate that the post should be in a published state with a past publication date.
     *
     * @return static The factory instance with published state applied.
     */
    public function published(): static
    {
        return $this->state(fn (): array => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ]);
    }

    /**
     * Indicate that the post should be in a draft state with no publication date.
     *
     * @return static The factory instance with draft state applied.
     */
    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
