<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Post;
use App\Models\User;

/**
 * Policy for authorizing actions on post resources.
 *
 * Determines whether users can view, create, update, or delete posts
 * based on ownership and assigned permissions.
 */
final class PostPolicy
{
    /**
     * Determine whether any user can view the list of posts.
     *
     * @return bool Always returns true, allowing all users to browse posts.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific post.
     *
     * @param  User  $user  The authenticated user attempting to view the post.
     * @param  Post  $post  The post being viewed.
     * @return bool True if the user owns the post or has the posts edit permission.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsEdit);
    }

    /**
     * Determine whether any user can create a new post.
     *
     * @return bool Always returns true, allowing all authenticated users to create posts.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update a post.
     *
     * @param  User  $user  The authenticated user attempting the update.
     * @param  Post  $post  The post being updated.
     * @return bool True if the user owns the post or has the posts edit permission.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsEdit);
    }

    /**
     * Determine whether the user can delete a post.
     *
     * @param  User  $user  The authenticated user attempting the deletion.
     * @param  Post  $post  The post being deleted.
     * @return bool True if the user owns the post or has the posts delete permission.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsDelete);
    }
}
