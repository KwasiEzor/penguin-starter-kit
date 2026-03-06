<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AiAgentTemplateSeeder::class,
        ]);

        $tags = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'Tailwind CSS', 'DevOps', 'Testing', 'API', 'Tutorial', 'News'];

        // Create default categories
        $categoryNames = ['Technology', 'Tutorial', 'News', 'Opinion', 'Review', 'Guide'];
        $categories = collect($categoryNames)->map(fn (string $name): Category => Category::create(['name' => $name]));

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
