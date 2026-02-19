<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->text('excerpt')->nullable()->after('body');
            $table->string('meta_title', 255)->nullable()->after('excerpt');
            $table->string('meta_description', 255)->nullable()->after('meta_title');
        });

        // Back-fill slugs from existing titles
        $posts = DB::table('posts')->select('id', 'title')->get();
        foreach ($posts as $post) {
            $baseSlug = Str::slug($post->title);
            $slug = $baseSlug;
            $counter = 2;
            while (DB::table('posts')->where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }
            DB::table('posts')->where('id', $post->id)->update(['slug' => $slug]);
        }

        // Now make slug non-nullable and unique
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['slug', 'excerpt', 'meta_title', 'meta_description']);
        });
    }
};
