<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group', 'key', 'value', 'type', 'label', 'description',
    ];

    /**
     * Ambil value setting berdasarkan key
     */
    public static function get(string $key, $default = null)
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set value setting
     */
    public static function set(string $key, $value, string $type = 'string', ?string $group = null, ?string $label = null, ?string $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group ?? 'general',
                'label' => $label,
                'description' => $description,
            ]
        );

        Cache::forget("setting.{$key}");

        return $setting;
    }

    /**
     * Ambil semua settings per group
     */
    public static function getGroup(string $group): array
    {
        return self::where('group', $group)
            ->pluck('value', 'key')
            ->mapWithKeys(function ($value, $key) {
                $setting = self::where('key', $key)->first();
                return [$key => self::castValue($value, $setting->type ?? 'string')];
            })
            ->toArray();
    }

    /**
     * Set multiple settings sekaligus
     */
    public static function setGroup(string $group, array $settings)
    {
        foreach ($settings as $key => $value) {
            $existing = self::where('key', $key)->first();
            $type = $existing?->type ?? 'string';

            self::set($key, $value, $type, $group);
        }
    }

    /**
     * Cast value berdasarkan type
     */
    protected static function castValue($value, string $type)
    {
        return match ($type) {
            'integer' => (int) $value,
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            default => (string) $value,
        };
    }
}
