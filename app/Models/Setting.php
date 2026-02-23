<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Represents an application setting stored as a key-value pair.
 *
 * Settings are grouped by category and cached indefinitely for performance.
 * Provides static helper methods for getting and setting values.
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Retrieve a setting value by its key, using cache for performance.
     *
     * Falls back to the provided default if the setting does not exist or the
     * settings table has not been created yet.
     *
     * @param  string  $key  The setting key to look up
     * @param  mixed  $default  The default value if the setting is not found
     * @return mixed The setting value or the default
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever('setting.'.$key, function () use ($key, $default) {
            try {
                if (! Schema::hasTable('settings')) {
                    return $default;
                }

                $setting = static::where('key', $key)->first();

                return $setting->value ?? $default;
            } catch (\Exception) {
                return $default;
            }
        });
    }

    /**
     * Create or update a setting and bust its cache entry.
     *
     * @param  string  $key  The setting key
     * @param  mixed  $value  The value to store
     * @param  string  $group  The group this setting belongs to
     * @return void
     */
    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group],
        );

        Cache::forget('setting.'.$key);
    }

    /**
     * Determine whether the payments feature is enabled globally.
     *
     * @return bool True if the "payments.enabled" setting is truthy
     */
    public static function paymentsEnabled(): bool
    {
        return (bool) static::get('payments.enabled', false);
    }
}
