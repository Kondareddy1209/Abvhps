<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get($key, $default = null)
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value, $group = 'general')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
        Cache::forget("site_setting_{$key}");
        return $setting;
    }

    public static function getAllSettings()
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    /**
     * Get the configured official WhatsApp contact number.
     * Default: +91 9989980055
     */
    public static function getWhatsAppNumber(): string
    {
        return static::get('whatsapp_number', '+91 9989980055');
    }

    /**
     * Get canonical/normalized international format for WhatsApp URL (e.g. 919989980055).
     * Strips +, spaces, hyphens, brackets and ensures country code.
     */
    public static function getNormalizedWhatsAppNumber(): string
    {
        $raw = static::getWhatsAppNumber();
        $digits = preg_replace('/[^0-9]/', '', (string)$raw);

        if (strlen($digits) === 10) {
            return '91' . $digits;
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            return '91' . substr($digits, 1);
        }

        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            return $digits;
        }

        return !empty($digits) ? $digits : '919989980055';
    }

    /**
     * Generate canonical wa.me URL for the configured WhatsApp number.
     */
    public static function getWhatsAppUrl(?string $message = null): string
    {
        $normalized = static::getNormalizedWhatsAppNumber();
        $url = 'https://wa.me/' . $normalized;

        if (!empty($message)) {
            $url .= '?text=' . urlencode($message);
        }

        return $url;
    }
}
