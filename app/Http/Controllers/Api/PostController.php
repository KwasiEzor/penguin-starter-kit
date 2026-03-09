<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * API controller for managing blog posts.
 *
 * Provides RESTful CRUD endpoints for posts, including support for
 * filtering by status, tag syncing, category assignment, and automatic
 * published_at timestamp management.
 */
final class PostController extends Controller
{
    /**
     * List the authenticated user's posts.
     *
     * Returns a paginated collection of posts belonging to the authenticated user,
     * eager-loaded with tags and categories.
     *
     * @queryParam status string Filter by status (draft or published). Example: published
     *
     * @param  Request  $request  The incoming HTTP request (may include 'status' query param)
     * @return JsonResource A paginated JSON resource collection of posts
     */
    public function index(Request $request): JsonResource
    {
        $posts = $request->user()
            ->posts()
            ->with(['tags', 'categories'])
            ->when($request->query('status'), fn (\Illuminate\Database\Eloquent\Builder $q, string $status) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return PostResource::collection($posts);
    }

    /**
     * Create a new post.
     *
     * Validates the request data, creates the post, syncs tags and categories
     * if provided, and sets the published_at timestamp if the status is 'published'.
     *
     * @bodyParam title string required The title of the post. Example: My First Post
     * @bodyParam body string required The content of the post. Example: This is the body.
     * @bodyParam status string Filter by status (draft or published). Example: published
     * @bodyParam tags string[] List of tags to sync. Example: ["tech", "laravel"]
     * @bodyParam category_ids integer[] List of category IDs to sync. Example: [1, 2]
     *
     * @param  StorePostRequest  $request  The validated incoming request with post data
     * @return \Illuminate\Http\JsonResponse A JSON response with the created post and 201 status code
     */
    public function store(StorePostRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        if (($validated['status'] ?? 'draft') === 'published') {
            $validated['published_at'] = now();
        }

        $tags = $validated['tags'] ?? [];
        $categoryIds = $validated['category_ids'] ?? [];
        unset($validated['tags'], $validated['category_ids']);

        $post = $request->user()->posts()->create($validated);

        if (! empty($tags)) {
            $post->syncTags($tags);
        }

        if (! empty($categoryIds)) {
            $post->categories()->sync($categoryIds);
        }

        $post->load(['tags', 'categories']);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display a single post.
     *
     * Authorizes the request against the PostPolicy before returning the post.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Post  $post  The post to display (resolved via route model binding)
     * @return PostResource A JSON resource representing the post
     */
    public function show(Request $request, Post $post): PostResource
    {
        $this->authorize('view', $post);

        $post->load(['tags', 'categories']);

        return new PostResource($post);
    }

    /**
     * Update an existing post.
     *
     * Validates the input, updates the post fields,
     * and syncs tags and categories if provided. Manages the published_at
     * timestamp when the status changes between draft and published.
     *
     * @bodyParam title string The title of the post. Example: Updated Title
     * @bodyParam body string The content of the post. Example: Updated body.
     * @bodyParam status string Filter by status (draft or published). Example: draft
     * @bodyParam tags string[] List of tags to sync. Example: ["php"]
     * @bodyParam category_ids integer[] List of category IDs to sync. Example: [1]
     *
     * @param  UpdatePostRequest  $request  The validated incoming request with updated post data
     * @param  Post  $post  The post to update (resolved via route model binding)
     * @return PostResource A JSON resource representing the updated post
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $validated = $request->validated();

        if (isset($validated['status']) && $validated['status'] === 'published' && ! $post->published_at) {
            $validated['published_at'] = now();
        }

        if (isset($validated['status']) && $validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $tags = $validated['tags'] ?? null;
        $categoryIds = $validated['category_ids'] ?? null;
        unset($validated['tags'], $validated['category_ids']);

        $post->update($validated);

        if ($tags !== null) {
            $post->syncTags($tags);
        }

        if ($categoryIds !== null) {
            $post->categories()->sync($categoryIds);
        }

        return new PostResource($post->fresh()->load(['tags', 'categories']));
    }

    /**
     * Delete a post.
     *
     * Authorizes the request against the PostPolicy before deleting the post.
     *
     * @param  Request  $request  The incoming HTTP request
     * @param  Post  $post  The post to delete (resolved via route model binding)
     * @return Response An empty 204 No Content response
     */
    public function destroy(Request $request, Post $post): Response
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }
}
