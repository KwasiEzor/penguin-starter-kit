<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Post;
use App\Models\User;

final class PostPolicy
{
    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsEdit);
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsEdit);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasPermissionTo(PermissionEnum::PostsDelete);
    }
}
