<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'UI/UX Design',
                'description' => 'We craft intuitive, user-centered interfaces that turn complex problems into delightful experiences. From wireframes to high-fidelity prototypes, our design process is driven by research, testing, and deep empathy for your users.',
                'icon' => 'palette',
                'features' => ['User Research & Personas', 'Wireframing & Prototyping', 'Interaction Design', 'Design Systems', 'Usability Testing', 'UI Animation'],
                'price_from' => 1200,
                'sort_order' => 1,
            ],
            [
                'title' => 'Web Design',
                'description' => 'Beautiful, responsive websites that reflect your brand and convert visitors into customers. Our designs are modern, accessible, and built to perform on every device.',
                'icon' => 'monitor',
                'features' => ['Responsive Design', 'Landing Page Design', 'Corporate Websites', 'Brand Identity Integration', 'SEO-Friendly Layouts', 'CMS-Ready Templates'],
                'price_from' => 800,
                'sort_order' => 2,
            ],
            [
                'title' => 'Web Application Development',
                'description' => 'We build powerful, scalable web applications using modern technologies like Laravel, React, and Vue. From SaaS platforms to complex business tools, we deliver robust solutions tailored to your needs.',
                'icon' => 'code',
                'features' => ['Custom Web Applications', 'SaaS Platform Development', 'RESTful API Design & Integration', 'Admin Panels & Dashboards', 'Payment Integration', 'Performance Optimization'],
                'price_from' => 5000,
                'sort_order' => 3,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'From concept to App Store, we develop native and cross-platform mobile apps that deliver seamless experiences. iOS, Android, or both — we build apps your users will love.',
                'icon' => 'smartphone',
                'features' => ['iOS & Android Development', 'React Native / Flutter', 'Mobile UI/UX Design', 'Push Notifications', 'Offline Capabilities', 'App Store Publishing'],
                'price_from' => 8000,
                'sort_order' => 4,
            ],
            [
                'title' => 'E-commerce Solutions',
                'description' => 'We build conversion-focused online stores with seamless checkout, inventory management, and payment processing. Whether you are launching or scaling, we have the expertise.',
                'icon' => 'shopping-cart',
                'features' => ['Store Setup & Configuration', 'Payment Gateway Integration', 'Order & Inventory Management', 'Product Catalog Design', 'Shipping Integration', 'Analytics & Reporting'],
                'price_from' => 3000,
                'sort_order' => 5,
            ],
            [
                'title' => 'Maintenance & Support',
                'description' => 'Keep your digital products running smoothly with our ongoing maintenance, security updates, and dedicated support. We ensure your applications stay fast, secure, and up-to-date.',
                'icon' => 'lifebuoy',
                'features' => ['Security & Performance Monitoring', 'Bug Fixes & Hotfixes', 'Feature Enhancements', 'Backup & Disaster Recovery', '24/7 Support Availability', 'Monthly Reports'],
                'price_from' => 500,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                array_merge($service, [
                    'image' => null,
                    'is_active' => true,
                ])
            );
        }
    }
}
