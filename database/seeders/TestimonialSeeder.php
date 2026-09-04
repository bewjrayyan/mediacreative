<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Sarah Chen',
                'role' => 'CEO',
                'company' => 'TechNova',
                'content' => 'The team at this agency exceeded all our expectations. They delivered our CRM platform on time and on budget, and the quality of work is outstanding. Highly recommended!',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Michael Rodriguez',
                'role' => 'Marketing Director',
                'company' => 'GreenLeaf',
                'content' => 'Our e-commerce site has never performed better. Conversion rates are up 40% since launch. The design is beautiful and the team was a pleasure to work with.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Emily Davidson',
                'role' => 'Product Manager',
                'company' => 'Northwind',
                'content' => 'From the initial wireframes to the final release, the communication was flawless. They truly understood our needs and delivered a banking dashboard our clients love.',
                'rating' => 5,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'James O\'Brien',
                'role' => 'Founder',
                'company' => 'Cloud9',
                'content' => 'Professional, creative, and technically brilliant. They built our travel platform from scratch and now we serve thousands of customers a month. Worth every penny.',
                'rating' => 5,
                'sort_order' => 4,
            ],
            [
                'client_name' => 'Maria Gonzalez',
                'role' => 'Operations Lead',
                'company' => 'BrightPath',
                'content' => 'The redesign of our healthcare app was handled with incredible care. They respected accessibility requirements and our users have given it rave reviews.',
                'rating' => 4,
                'sort_order' => 5,
            ],
            [
                'client_name' => 'David Kim',
                'role' => 'CTO',
                'company' => 'DataFlow',
                'content' => 'A rare agency that manages both design and development with equal skill. Their analytics platform handles millions of data points without breaking a sweat.',
                'rating' => 5,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonial['client_name']],
                array_merge($testimonial, [
                    'avatar' => null,
                    'is_active' => true,
                ])
            );
        }
    }
}
