<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Application user role definitions.
 *
 * Defines the available roles that can be assigned to users for role-based
 * access control. Each role maps to a set of permissions defined in the
 * database seeder.
 *
 * @case Admin  - Full administrative access to all features
 * @case Editor - Content management access for creating and editing posts
 * @case User   - Basic user access with limited permissions
 */
enum RoleEnum: string
{
    /** Administrator role with full access to all application features. */
    case Admin = 'admin';

    /** Editor role with content management capabilities. */
    case Editor = 'editor';

    /** Standard user role with basic access permissions. */
    case User = 'user';

    /**
     * Get the human-readable display label for this role.
     *
     * @return string The formatted role name
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Editor => 'Editor',
            self::User => 'User',
        };
    }
}
