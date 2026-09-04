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


            // ── Services page ──────────────────────────────
            ['key' => 'services_intro_title', 'value' => 'Builders, not just vendors', 'group' => 'services_page'],
            ['key' => 'services_intro_body', 'value' => 'We\'re not just a service provider — we\'re builders ourselves. We\'ve created and launched our own products, so we know what it takes to turn ideas into reality.

We\'re excited to bring that same framework — the stack we use on our own products — to yours. Before we commit, we\'ll take an honest look at your brief and confirm we\'re the right fit to help.

When we are, we\'ll plan, design, develop, publish and deploy apps and admin dashboards on web and mobile.', 'group' => 'services_page'],
            ['key' => 'services_intro_stack', 'value' => 'We use modern technologies to build your software. React drives the interfaces users touch every day; Laravel runs the APIs, admin panels, and business logic behind them — a full-stack pairing built to ship fast and scale with your product.', 'group' => 'services_page'],
            ['key' => 'services_flow_heading', 'value' => 'Service Flow', 'group' => 'services_page'],
            ['key' => 'services_flow_subheading', 'value' => 'From first conversation to launch — how we typically work with you.', 'group' => 'services_page'],
            ['key' => 'services_flow_steps', 'value' => '[
  {
    "title": "Discovery & Planning",
    "description": "We start by understanding your goals, users, and scope — mapping what to build before writing code."
  },
  {
    "title": "UI / UX Design",
    "description": "Wireframes, flows, and visual design so the product is clear to stakeholders and ready for development."
  },
  {
    "title": "Development",
    "description": "Modern web and mobile builds with a solid backend — shipped in parallel where it makes sense."
  },
  {
    "title": "Testing & Refinement",
    "description": "QA, device testing, and feedback rounds to catch issues early and polish the experience."
  },
  {
    "title": "Launch",
    "description": "Deploy to production, publish where needed, and hand over what you need to run it."
  },
  {
    "title": "Support & Iteration",
    "description": "Fixes, updates, and new features as your product grows — with the same team that built it."
  }
]', 'group' => 'services_page'],
            ['key' => 'services_tech_heading', 'value' => 'Technologies We Use', 'group' => 'services_page'],
            ['key' => 'services_tech_subheading', 'value' => 'We use the latest modern technologies to build your software.', 'group' => 'services_page'],
            ['key' => 'services_technologies', 'value' => 'Laravel, Expo, React, React Native, Tailwind CSS, Bootstrap, iOS, Android', 'group' => 'services_page'],
            ['key' => 'services_quote', 'value' => 'Plan & design before jumping into coding to make sure we get everything covered.', 'group' => 'services_page'],
            ['key' => 'services_bottom_cta_title', 'value' => 'Hire us to build your custom software — web, mobile, or both.', 'group' => 'services_page'],
            ['key' => 'services_bottom_cta_body', 'value' => 'Every business deserves digital products that retain customers and create real value. We\'re here to help with a free consultation on where and how to start.', 'group' => 'services_page'],
            ['key' => 'services_bottom_cta_button', 'value' => 'Send enquiry', 'group' => 'services_page'],

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
