<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

/**
 * Represents a category that can be assigned to categorizable models via a polymorphic relationship.
 *
 * A slug is automatically generated from the name upon creation if not provided.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $posts
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    /**
     * Boot the model and register event listeners.
     *
     * Automatically generates a slug from the name when creating a category
     * if no slug has been provided.
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::deleting(function (Category $category): bool {
            if ($category->posts()->exists()) {
                throw new \RuntimeException('Cannot delete category because it has associated posts.');
            }

            return true;
        });
    }

    /**
     * Get all posts that belong to this category.
     *
     * @return MorphToMany<Post, $this>
     */
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'categorizable');
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
