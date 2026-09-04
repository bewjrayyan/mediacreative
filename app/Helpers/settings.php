<?php

use App\Models\PageSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Get a setting value by key from the page_settings table, cached.
     * Supports flat keys ("email") and group.key ("contact.email").
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('page_settings_v2', 3600, function () {
            $flat = [];

            foreach (PageSetting::query()->get(['key', 'value', 'group']) as $row) {
                $flat[$row->key] = $row->value;

                if (filled($row->group)) {
                    $flat[$row->group.'.'.$row->key] = $row->value;
                }
            }

            return $flat;
        });

        $value = $settings[$key] ?? null;

        // Legacy: JSON blob under a parent key (e.g. key "social" = {"facebook":"..."})
        if ($value === null && str_contains($key, '.')) {
            [$groupKey, $itemKey] = explode('.', $key, 2);
            $groupValue = $settings[$groupKey] ?? null;
            if (is_string($groupValue) && is_array(json_decode($groupValue, true))) {
                $decoded = json_decode($groupValue, true);
                $value = $decoded[$itemKey] ?? null;
            }

            // Flat key fallback: contact.email → email
            if ($value === null) {
                $value = $settings[$itemKey] ?? null;
            }
        }

        return $value ?? $default;
    }
}

if (! function_exists('setting_trans')) {
    /**
     * Setting value translated for the current locale (JSON catalog lookup).
     * Falls back to the raw value when no translation exists.
     */
    function setting_trans(string $key, ?string $default = null): string
    {
        $value = setting($key, $default);

        if ($value === null || $value === '') {
            return $default !== null ? (string) __($default) : '';
        }

        return (string) __(trim((string) $value));
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


if (! function_exists('setting_json')) {
    /**
     * Decode a JSON setting into an array (empty array on failure).
     *
     * @return array<int|string, mixed>
     */
    function setting_json(string $key, array $default = []): array
    {
        $raw = setting($key);
        if ($raw === null || $raw === '') {
            return $default;
        }
        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : $default;
    }
}

if (! function_exists('site_name')) {
    function site_name(): string
    {
        return setting('site_name', setting('site.name', config('app.name', 'DesignPro')));
    }
}
