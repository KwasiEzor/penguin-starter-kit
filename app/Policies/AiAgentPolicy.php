<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\AiAgent;
use App\Models\User;

/**
 * Policy for authorizing actions on AI agent resources.
 *
 * Determines whether users can view, create, update, delete, or execute
 * AI agents based on ownership, public visibility, and permissions.
 */
final class AiAgentPolicy
{
    /**
     * Determine whether any user can view the list of AI agents.
     *
     * @return bool Always returns true, allowing all users to browse agents.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific AI agent.
     *
     * @param  User     $user     The authenticated user attempting to view the agent.
     * @param  AiAgent  $aiAgent  The AI agent being viewed.
     * @return bool True if the user owns the agent or the agent is public.
     */
    public function view(User $user, AiAgent $aiAgent): bool
    {
        return $user->id === $aiAgent->user_id || $aiAgent->is_public;
    }

    /**
     * Determine whether any user can create a new AI agent.
     *
     * @return bool Always returns true, allowing all authenticated users to create agents.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update an AI agent.
     *
     * @param  User     $user     The authenticated user attempting the update.
     * @param  AiAgent  $aiAgent  The AI agent being updated.
     * @return bool True if the user owns the agent or has the AI agents manage permission.
     */
    public function update(User $user, AiAgent $aiAgent): bool
    {
        return $user->id === $aiAgent->user_id || $user->hasPermissionTo(PermissionEnum::AiAgentsManage);
    }

    /**
     * Determine whether the user can delete an AI agent.
     *
     * @param  User     $user     The authenticated user attempting the deletion.
     * @param  AiAgent  $aiAgent  The AI agent being deleted.
     * @return bool True if the user owns the agent or has the AI agents manage permission.
     */
    public function delete(User $user, AiAgent $aiAgent): bool
    {
        return $user->id === $aiAgent->user_id || $user->hasPermissionTo(PermissionEnum::AiAgentsManage);
    }

    /**
     * Determine whether the user can execute an AI agent.
     *
     * @param  User     $user     The authenticated user attempting to execute the agent.
     * @param  AiAgent  $aiAgent  The AI agent being executed.
     * @return bool True if the user owns the agent, or the agent is both public and active.
     */
    public function execute(User $user, AiAgent $aiAgent): bool
    {
        return $user->id === $aiAgent->user_id || ($aiAgent->is_public && $aiAgent->is_active);
    }
}
