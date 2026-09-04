<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::pluck('id', 'title')->toArray();

        $messages = [
            [
                'name' => 'Jane Cooper',
                'email' => 'jane.cooper@example.com',
                'phone' => '+1 (555) 111-2222',
                'subject' => 'Website redesign inquiry',
                'service' => 'Web Design',
                'message' => 'Hi there! We\'re looking to redesign our corporate website. We need something modern, faster, and more conversion-focused. Could you share your process and timeline?',
                'status' => 'new',
            ],
            [
                'name' => 'Robert Chen',
                'email' => 'robert.chen@example.com',
                'phone' => '+1 (555) 333-4444',
                'subject' => 'SaaS platform development',
                'service' => 'Web Application Development',
                'message' => 'I have a SaaS idea and need help building a minimum viable product. Looking for a dev team that can also help with UI/UX design. What would an MVP cost?',
                'status' => 'new',
            ],
            [
                'name' => 'Michael Torres',
                'email' => 'michael.torres@example.com',
                'phone' => '+1 (555) 555-6666',
                'subject' => 'Mobile app consultation',
                'service' => 'Mobile App Development',
                'message' => 'We need a cross-platform mobile app for our delivery service. We\'d like to understand your experience with React Native and what kind of app you\'ve shipped.',
                'status' => 'read',
            ],
            [
                'name' => 'Sarah Mitchell',
                'email' => 'sarah.mitchell@example.com',
                'phone' => '+1 (555) 777-8888',
                'subject' => 'E-commerce store migration',
                'service' => 'E-commerce Solutions',
                'message' => 'We currently run on Shopify but want to migrate to a custom solution for more control. Our store has about 2,000 products. Can you help?',
                'status' => 'read',
            ],
            [
                'name' => 'David Johnson',
                'email' => 'david.johnson@example.com',
                'phone' => '+1 (555) 999-0000',
                'subject' => 'UI/UX audit request',
                'service' => 'UI/UX Design',
                'message' => 'Could you perform a usability audit of our current web app? We have high bounce rates and want to understand where users are dropping off.',
                'status' => 'replied',
            ],
            [
                'name' => 'Laura Bennett',
                'email' => 'laura.bennett@example.com',
                'phone' => '+1 (555) 222-3333',
                'subject' => 'Ongoing maintenance package',
                'service' => 'Maintenance & Support',
                'message' => 'We need ongoing support for our Laravel application. What does your monthly maintenance package include?',
                'status' => 'new',
            ],
            [
                'name' => 'John Miller',
                'email' => 'john.miller@example.com',
                'phone' => '+1 (555) 444-5555',
                'subject' => 'Startup website',
                'service' => 'Web Design',
                'message' => 'We\'re launching a startup and need a great landing page + brochure site. We want something that makes us look bigger and more credible.',
                'status' => 'new',
            ],
            [
                'name' => 'Grace Park',
                'email' => 'grace.park@example.com',
                'phone' => '+1 (555) 666-7777',
                'subject' => 'Admin dashboard development',
                'service' => 'Web Application Development',
                'message' => 'We need an internal admin panel to manage our data. Would be used by about 50 internal users. Looking for a timeline and rough estimate.',
                'status' => 'read',
            ],
            [
                'name' => 'Kevin Nguyen',
                'email' => 'kevin.nguyen@example.com',
                'phone' => '+1 (555) 888-9999',
                'subject' => 'iOS app for fitness brand',
                'service' => 'Mobile App Development',
                'message' => 'Hello! We have a fitness brand and need an iOS app to complement our wearable devices. Looking for a partner who can handle design and development.',
                'status' => 'new',
            ],
            [
                'name' => 'Anna Rodriguez',
                'email' => 'anna.rodriguez@example.com',
                'phone' => '+1 (555) 000-1111',
                'subject' => 'Portfolio site for design work',
                'service' => 'Web Design',
                'message' => 'Hi, I\'m a freelance designer and need a portfolio website to showcase my work. Looking for something very visual and unique.',
                'status' => 'replied',
            ],
        ];

        foreach ($messages as $index => $msg) {
            $serviceId = $services[$msg['service']] ?? null;

            ContactMessage::create([
                'name' => $msg['name'],
                'email' => $msg['email'],
                'phone' => $msg['phone'],
                'subject' => $msg['subject'],
                'service_id' => $serviceId,
                'message' => $msg['message'],
                'status' => $msg['status'],
                'created_at' => now()->subDays($index),
            ]);
        }
    }
}
