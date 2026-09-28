<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table    = 'site_settings';
    protected $fillable = ['key', 'value'];

    /** Get a setting value, with optional default. */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting.{$key}", 300, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /** Set (upsert) a setting value and bust its cache. */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting.{$key}");
    }

    /** Return all settings as a key => value array. */
    public static function getAllSettings(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return static::query()->get($columns);
    }
}
