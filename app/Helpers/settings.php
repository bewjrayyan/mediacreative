<?php

use App\Models\PageSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Get a setting value by key from the page_settings table, cached.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('page_settings', 3600, function () {
            return PageSetting::all()->pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? null;

        // Try dot-notation lookups (e.g. 'social.facebook')
        if ($value === null && str_contains($key, '.')) {
            [$groupKey, $itemKey] = explode('.', $key, 2);
            $groupValue = $settings[$groupKey] ?? null;
            if (is_array(json_decode($groupValue, true))) {
                $decoded = json_decode($groupValue, true);
                $value = $decoded[$itemKey] ?? null;
            }
        }

        return $value ?? $default;
    }
}

if (! function_exists('setting_group')) {
    /**
     * Get all settings for a group (e.g. 'general', 'social').
     */
    function setting_group(string $group): array
    {
        return PageSetting::where('group', $group)
            ->pluck('value', 'key')
            ->map(function ($value) {
                $decoded = json_decode((string) $value, true);
                return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
            })
            ->toArray();
    }
}

if (! function_exists('site_name')) {
    function site_name(): string
    {
        return setting('site.name', config('app.name', 'DesignPro'));
    }
}
