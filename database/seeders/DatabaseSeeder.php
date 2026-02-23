<?php

namespace Database\Seeders;

use App\Models\AiAgent;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $tags = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'Tailwind CSS', 'DevOps', 'Testing', 'API', 'Tutorial', 'News'];

        // Create default categories
        $categoryNames = ['Technology', 'Tutorial', 'News', 'Opinion', 'Review', 'Guide'];
        $categories = collect($categoryNames)->map(fn (string $name): Category => Category::create(['name' => $name]));

        // Admin user
        $adminUser = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        Post::factory(5)->for($adminUser)->create();

        // Sample AI Agents
        AiAgent::create([
            'user_id' => $adminUser->id,
            'name' => 'General Assistant',
            'description' => 'A general-purpose AI assistant powered by OpenAI.',
            'provider' => 'openai',
            'model' => 'gpt-4o',
            'system_prompt' => 'You are a helpful, concise assistant. Answer questions clearly and accurately.',
            'temperature' => 0.7,
            'max_tokens' => 1024,
            'is_active' => true,
            'is_public' => true,
        ]);
        AiAgent::create([
            'user_id' => $adminUser->id,
            'name' => 'Code Reviewer',
            'description' => 'Reviews code and suggests improvements using Anthropic Claude.',
            'provider' => 'anthropic',
            'model' => 'claude-sonnet-4-5-20250929',
            'system_prompt' => 'You are an expert code reviewer. Analyze the provided code for bugs, performance issues, and best practices. Provide specific, actionable feedback.',
            'temperature' => 0.3,
            'max_tokens' => 2048,
            'is_active' => true,
            'is_public' => true,
        ]);
        AiAgent::create([
            'user_id' => $adminUser->id,
            'name' => 'Content Writer',
            'description' => 'Generates creative content using Google Gemini.',
            'provider' => 'gemini',
            'model' => 'gemini-2.0-flash',
            'system_prompt' => 'You are a skilled content writer. Write engaging, well-structured content based on the given topic or brief.',
            'temperature' => 0.9,
            'max_tokens' => 2048,
            'is_active' => true,
            'is_public' => true,
        ]);

        // Editor users
        User::factory(3)->editor()
            ->has(Post::factory()->count(4))
            ->create();

        // Regular users
        User::factory(5)
            ->has(Post::factory()->count(3))
            ->create();

        // Attach random tags and categories to all posts
        Post::all()->each(function (Post $post) use ($tags, $categories): void {
            $randomTags = collect($tags)->random(random_int(1, 3))->toArray();
            $post->attachTags($randomTags);

            $randomCategories = $categories->random(random_int(1, 2))->pluck('id')->toArray();
            $post->categories()->sync($randomCategories);
        });
    }
}
