<?php

namespace Database\Seeders;

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

        // Admin user
        $adminUser = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        Post::factory(5)->for($adminUser)->create();

        // Editor users
        User::factory(3)->editor()
            ->has(Post::factory()->count(4))
            ->create();

        // Regular users
        User::factory(5)
            ->has(Post::factory()->count(3))
            ->create();

        // Attach random tags to all posts
        Post::all()->each(function (Post $post) use ($tags): void {
            $randomTags = collect($tags)->random(random_int(1, 3))->toArray();
            $post->attachTags($randomTags);
        });
    }
}
