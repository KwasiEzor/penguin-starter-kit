<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Session;

/**
 * Helper class for flashing toast notification messages to the session.
 *
 * Provides static convenience methods for creating success, warning,
 * error, and info toast notifications that are displayed on the next
 * page load.
 */
final class Toast
{
    /**
     * Flash a success toast notification to the session.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public static function success(string $content): void
    {
        self::add($content, 'success');
    }

    /**
     * Flash a warning toast notification to the session.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public static function warning(string $content): void
    {
        self::add($content, 'warning');
    }

    /**
     * Flash an error toast notification to the session.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public static function error(string $content): void
    {
        self::add($content, 'error');
    }

    /**
     * Flash an info toast notification to the session.
     *
     * @param  string  $content  The message to display in the toast.
     * @return void
     */
    public static function info(string $content): void
    {
        self::add($content, 'info');
    }

    /**
     * Flash a toast notification of the given type to the session.
     *
     * @param  string  $content  The message to display in the toast.
     * @param  string  $type     The notification type (e.g., 'success', 'warning', 'error', 'info').
     * @return void
     */
    public static function add(string $content, string $type): void
    {
        Session::flash('notify', [
            'content' => $content,
            'type' => $type,
        ]);
    }
}
