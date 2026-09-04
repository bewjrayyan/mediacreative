<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Nexus CRM Platform',
                'category' => 'Web App',
                'client' => 'TechNova',
                'description' => 'A comprehensive customer relationship management platform built for modern sales teams. Features include pipeline tracking, email automation, analytics dashboards, and team collaboration tools.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis'],
                'url' => 'https://nexus-crm.example.com',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Bloom E-commerce Store',
                'category' => 'E-commerce',
                'client' => 'GreenLeaf',
                'description' => 'A fully-featured online store for a skincare brand, with custom product configurators, subscription management, and seamless multi-currency checkout.',
                'technologies' => ['Laravel', 'Alpine.js', 'Stripe', 'PostgreSQL'],
                'url' => 'https://bloom.example.com',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Pulse Fitness App',
                'category' => 'Mobile',
                'client' => 'Acme Corp',
                'description' => 'A cross-platform fitness tracking app with workout plans, nutrition logging, wearable integration, and social features to keep users motivated.',
                'technologies' => ['React Native', 'Node.js', 'MongoDB'],
                'url' => 'https://pulse.example.com',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'FinEdge Banking Dashboard',
                'category' => 'Web App',
                'client' => 'Northwind',
                'description' => 'A secure financial dashboard with real-time transaction monitoring, fraud detection alerts, and comprehensive reporting for enterprise banking clients.',
                'technologies' => ['React', 'TypeScript', 'Spring Boot', 'PostgreSQL'],
                'url' => 'https://finedge.example.com',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Insight Analytics Suite',
                'category' => 'Web App',
                'client' => 'DataFlow',
                'description' => 'A powerful data analytics platform with drag-and-drop report builders, real-time dashboards, and AI-powered insights for business intelligence teams.',
                'technologies' => ['Vue.js', 'Laravel', 'ClickHouse', 'D3.js'],
                'url' => 'https://insight.example.com',
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'TravelMate Booking Portal',
                'category' => 'Website',
                'client' => 'Cloud9',
                'description' => 'A modern travel booking website with flight and hotel comparison, interactive maps, user reviews, and a loyalty rewards program.',
                'technologies' => ['Laravel', 'Tailwind CSS', 'Redis', 'Maps API'],
                'url' => 'https://travelmate.example.com',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'HealthCare App Redesign',
                'category' => 'UI/UX',
                'client' => 'BrightPath',
                'description' => 'Complete UX/UI redesign of a healthcare app, improving patient onboarding, appointment scheduling, and medication tracking while meeting strict accessibility standards.',
                'technologies' => ['Figma', 'Design Systems', 'Usability Testing'],
                'url' => null,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'RetailPro POS System',
                'category' => 'Web App',
                'client' => 'Acme Corp',
                'description' => 'A cloud-based point-of-sale system with inventory tracking, staff management, and multi-location support for growing retail businesses.',
                'technologies' => ['Laravel', 'Livewire', 'MySQL', 'Kubernetes'],
                'url' => 'https://retailpro.example.com',
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'title' => 'EduLearn e-Learning Platform',
                'category' => 'Website',
                'client' => 'Visionary',
                'description' => 'An interactive learning management system with video courses, quizzes, progress tracking, and community forums for students worldwide.',
                'technologies' => ['Laravel', 'Vue.js', 'FFmpeg', 'AWS S3'],
                'url' => 'https://edulearn.example.com',
                'is_featured' => false,
                'status' => 'published',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                array_merge($project, [
                    'services' => [],
                ])
            );
        }
    }
}
