<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getByKey(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? ($setting->value['val'] ?? $setting->value) : $default;
    }

    public static function setKey(string $key, $value, string $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => is_array($value) ? $value : ['val' => $value],
            ]
        );
    }
}
