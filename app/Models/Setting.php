<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting.{$key}", function () use ($key, $default) {
            try {
                if (! Schema::hasTable('settings')) {
                    return $default;
                }

                $setting = static::where('key', $key)->first();

                return $setting?->value ?? $default;
            } catch (\Exception) {
                return $default;
            }
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group],
        );

        Cache::forget("setting.{$key}");
    }

    public static function paymentsEnabled(): bool
    {
        return (bool) static::get('payments.enabled', false);
    }
}
