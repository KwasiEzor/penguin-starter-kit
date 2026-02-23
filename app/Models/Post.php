<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;
use Tonysm\RichTextLaravel\Casts\AsRichTextContent;

/**
 * Represents a blog post with rich text content, media, tags, and categories.
 *
 * Posts support featured images via Spatie Media Library, tagging via Spatie Tags,
 * polymorphic categories, and rich text body content. A unique slug is
 * auto-generated from the title on creation and update.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string $slug
 * @property mixed $body
 * @property string|null $excerpt
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 */
class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
    ];

    /**
     * Get the attribute casting configuration for the model.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'body' => AsRichTextContent::class,
        ];
    }

    /**
     * Boot the model and register event listeners.
     *
     * Automatically generates a unique slug from the title when creating
     * or updating a post if no slug has been provided.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function (Post $post): void {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });

        static::updating(function (Post $post): void {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    /**
     * Generate a unique slug from the given title.
     *
     * If a slug derived from the title already exists, a numeric suffix is appended
     * and incremented until uniqueness is achieved.
     *
     * @param  string  $title  The title to generate the slug from
     * @param  int|null  $excludeId  An optional post ID to exclude from the uniqueness check (for updates)
     * @return string The unique slug
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($excludeId, fn(\Illuminate\Database\Eloquent\Builder $q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Get the user (author) who owns this post.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories assigned to this post via a polymorphic many-to-many relationship.
     *
     * @return MorphToMany<Category, $this>
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * Determine whether the post has been published.
     *
     * @return bool True if the post status is "published"
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Get the post excerpt, falling back to a truncated version of the body.
     *
     * @param  int  $limit  The maximum character length for the auto-generated excerpt
     * @return string The excerpt text
     */
    public function getExcerpt(int $limit = 160): string
    {
        if (! empty($this->excerpt)) {
            return $this->excerpt;
        }

        return Str::limit(strip_tags((string) ($this->body ?? '')), $limit);
    }

    /**
     * Register the media collections for this model.
     *
     * Defines a single-file "featured_image" collection.
     *
     * @return void
     */
    public function registerMediaCollections(): void

    {
        $this->addMediaCollection('featured_image')->singleFile();
    }

    /**
     * Get the URL of the featured image, falling back to a default blog image.
     *
     * @return string|null The featured image URL, or the default blog image URL
     */
    public function featuredImageUrl(): ?string
    {
        return $this->getFirstMediaUrl('featured_image') ?: Storage::url('blog-default.jpg');
    }
}
