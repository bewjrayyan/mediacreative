<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateSettingsRequest;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = PageSetting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle general settings
        $this->updateGroup('general', $request->only([
            'site_name', 'tagline', 'site_description',
        ]));

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            $this->saveSetting('general', 'logo', $logoPath);
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            $this->saveSetting('general', 'favicon', $faviconPath);
        }

        // Handle contact settings
        $this->updateGroup('contact', $request->only([
            'email', 'phone', 'address', 'map_embed',
        ]));

        // Handle social settings
        $this->updateGroup('social', $request->only([
            'facebook', 'instagram', 'linkedin', 'twitter', 'github',
        ]));

        // Handle SEO settings
        $this->updateGroup('seo', $request->only([
            'meta_title', 'meta_description', 'keywords',
        ]));

        if ($request->hasFile('og_image')) {
            $ogPath = $request->file('og_image')->store('settings', 'public');
            $this->saveSetting('seo', 'og_image', $ogPath);
        }

        // Handle homepage settings
        $this->updateGroup('home', $request->only([
            'hero_heading', 'hero_subheading', 'cta_text', 'cta_link',
        ]));

        if ($request->hasFile('hero_image')) {
            $heroPath = $request->file('hero_image')->store('settings', 'public');
            $this->saveSetting('home', 'hero_image', $heroPath);
        }

        // Handle footer settings
        $this->updateGroup('footer', $request->only([
            'copyright', 'quick_links',
        ]));

        // Handle services page (extra sections below service cards)
        $this->updateGroup('services_page', $request->only([
            'services_intro_title',
            'services_intro_body',
            'services_intro_stack',
            'services_flow_heading',
            'services_flow_subheading',
            'services_flow_steps',
            'services_tech_heading',
            'services_tech_subheading',
            'services_technologies',
            'services_quote',
            'services_bottom_cta_title',
            'services_bottom_cta_body',
            'services_bottom_cta_button',
        ]));

        Cache::forget('page_settings');
        Cache::forget('page_settings_v2');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings saved successfully.');
    }

    private function updateGroup(string $group, array $data): void
    {
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $this->saveSetting($group, $key, $value);
            }
        }
    }

    private function saveSetting(string $group, string $key, mixed $value): void
    {
        PageSetting::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value, 'group' => $group]
        );
    }
}
