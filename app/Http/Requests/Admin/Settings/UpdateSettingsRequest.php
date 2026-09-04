<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // General
            'general.site_name' => ['nullable', 'string', 'max:255'],
            'general.tagline' => ['nullable', 'string', 'max:255'],
            'general.logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'],
            'general.favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,svg,ico', 'max:1024'],
            // Contact
            'contact.email' => ['nullable', 'email', 'max:255'],
            'contact.phone' => ['nullable', 'string', 'max:50'],
            'contact.address' => ['nullable', 'string', 'max:500'],
            'contact.map_embed' => ['nullable', 'string', 'max:4000'],
            // Social
            'social.facebook' => ['nullable', 'url', 'max:255'],
            'social.instagram' => ['nullable', 'url', 'max:255'],
            'social.linkedin' => ['nullable', 'url', 'max:255'],
            'social.twitter' => ['nullable', 'url', 'max:255'],
            'social.github' => ['nullable', 'url', 'max:255'],
            // SEO
            'seo.meta_title' => ['nullable', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string', 'max:500'],
            'seo.keywords' => ['nullable', 'string', 'max:500'],
            'seo.og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            // Homepage
            'home.hero_heading' => ['nullable', 'string', 'max:500'],
            'home.hero_subheading' => ['nullable', 'string', 'max:1000'],
            'home.hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'home.cta_text' => ['nullable', 'string', 'max:255'],
            'home.cta_link' => ['nullable', 'string', 'max:255'],
            // Footer (flat keys matching the settings form + PageSetting rows)
            'copyright' => ['nullable', 'string', 'max:500'],
            'quick_links' => ['nullable', 'string', 'max:4000'],
        ];
    }
}
