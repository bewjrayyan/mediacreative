<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'content' => '<h2>Our Story</h2><p>Founded in 2015, DesignPro has grown from a two-person design studio into a full-service digital agency. We\'ve helped over 200 businesses launch, grow, and transform with great design and robust engineering.</p><h2>Our Approach</h2><p>We believe great digital products are the result of deep understanding, disciplined process, and relentless iteration. Every project starts with research and ends with measurable results.</p>',
                'meta_title' => 'About DesignPro | Our Story & Team',
                'meta_description' => 'Learn about DesignPro\'s journey, our team of designers and developers, and the process we follow to deliver exceptional digital products.',
                'is_active' => true,
            ],
            [
                'title' => 'Careers',
                'content' => '<h2>Join Our Team</h2><p>We\'re always looking for talented designers, developers, and project managers who are passionate about their craft. If that sounds like you, we\'d love to hear from you.</p><h3>Why Work With Us?</h3><ul><li>Remote-friendly culture</li><li>Competitive compensation</li><li>Real growth opportunities</li><li>Work on diverse interesting projects</li></ul>',
                'meta_title' => 'Careers at DesignPro',
                'meta_description' => 'Explore career opportunities at DesignPro, a growing digital design and development agency.',
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2><p>This Privacy Policy describes how DesignPro collects, uses, and shares information in connection with our website and services.</p><h3>Information We Collect</h3><p>When you contact us through our website, we collect the information you provide, including your name, email address, and any message content.</p><h3>How We Use Information</h3><p>We use the information you provide to respond to your inquiries and, if you opt in, to send you updates about our services.</p>',
                'meta_title' => 'Privacy Policy | DesignPro',
                'meta_description' => 'Read DesignPro\'s privacy policy to understand how we collect and use your information.',
                'is_active' => true,
            ],
            [
                'title' => 'Terms of Service',
                'content' => '<h2>Terms of Service</h2><p>These Terms of Service govern your use of the DesignPro website and services. By using our services, you agree to these terms.</p><h3>Services</h3><p>We provide design, development, and consulting services as agreed upon in individual project scopes and contracts.</p>',
                'meta_title' => 'Terms of Service | DesignPro',
                'meta_description' => 'Review the terms and conditions governing the use of DesignPro\'s services.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => Str::slug($page['title'])],
                $page
            );
        }
    }
}
