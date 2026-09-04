<?php

namespace Database\Seeders;

use App\Models\PageSetting;
use Illuminate\Database\Seeder;

class PageSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── General ─────────────────────────────────────
            ['key' => 'site_name', 'value' => 'DesignPro', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'We design. We build. We deliver.', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'DesignPro is a full-service design and development agency crafting beautiful, high-performing digital products.', 'group' => 'general'],
            ['key' => 'logo', 'value' => '', 'group' => 'general'],
            ['key' => 'favicon', 'value' => '', 'group' => 'general'],

            // ── Contact ─────────────────────────────────────
            ['key' => 'email', 'value' => 'hello@designpro.example.com', 'group' => 'contact'],
            ['key' => 'phone', 'value' => '+1 (555) 012-3456', 'group' => 'contact'],
            ['key' => 'address', 'value' => '123 Innovation Drive, Suite 400, San Francisco, CA 94107', 'group' => 'contact'],
            ['key' => 'map_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0193276899328!2d-122.41941648467913!3d37.77492977975965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c6c8f4459%3A0xb10ed6d9b5050fa5!2sTwitter%20HQ!5e0!3m2!1sen!2sus!4v1581234567890!5m2!1sen!2sus', 'group' => 'contact'],

            // ── Social ──────────────────────────────────────
            ['key' => 'facebook', 'value' => 'https://facebook.com/designpro', 'group' => 'social'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/designpro', 'group' => 'social'],
            ['key' => 'linkedin', 'value' => 'https://linkedin.com/company/designpro', 'group' => 'social'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/designpro', 'group' => 'social'],
            ['key' => 'github', 'value' => 'https://github.com/designpro', 'group' => 'social'],

            // ── SEO ─────────────────────────────────────────
            ['key' => 'meta_title', 'value' => 'DesignPro — Design & Web Application Development Agency', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'We craft beautiful websites and powerful web applications. UI/UX design, web development, mobile apps, and e-commerce solutions for ambitious businesses.', 'group' => 'seo'],
            ['key' => 'keywords', 'value' => 'web design, UI UX design, web development, mobile apps, e-commerce, Laravel development', 'group' => 'seo'],
            ['key' => 'og_image', 'value' => '', 'group' => 'seo'],

            // ── Homepage ────────────────────────────────────
            ['key' => 'hero_heading', 'value' => 'We Design & Build Digital Products That Make an Impact', 'group' => 'home'],
            ['key' => 'hero_subheading', 'value' => 'DesignPro is a full-service agency specializing in UI/UX design, web application development, and digital solutions that help ambitious businesses grow.', 'group' => 'home'],
            ['key' => 'hero_image', 'value' => '', 'group' => 'home'],
            ['key' => 'cta_text', 'value' => 'Start Your Project', 'group' => 'home'],
            ['key' => 'cta_link', 'value' => '/contact', 'group' => 'home'],

            // ── Footer ──────────────────────────────────────
            ['key' => 'copyright', 'value' => '© 2026 DesignPro. All rights reserved.', 'group' => 'footer'],
            ['key' => 'quick_links', 'value' => '{"Services":"/services","Portfolio":"/portfolio","About":"/about","Blog":"/blog","Contact":"/contact"}', 'group' => 'footer'],
        ];

        foreach ($settings as $setting) {
            PageSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
