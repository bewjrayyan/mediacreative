<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Top 10 Web Design Trends for 2026',
                'content' => "<p>The web design landscape is constantly evolving. As we move through 2026, several exciting trends are reshaping how we think about digital experiences.</p><h2>1. AI-Powered Personalization</h2><p>Websites are becoming smarter, adapting their content and layout to individual users in real-time. AI-driven design tools help us create experiences that feel personally tailored.</p><h2>2. Immersive 3D Elements</h2><p>With WebGL becoming more accessible, 3D design elements are no longer just for gaming sites. Subtle 3D touches can make a website feel more premium and engaging.</p><h2>3. Dark Mode by Default</h2><p>More users than ever prefer dark mode. Designing with both modes in mind from the start ensures a consistent brand experience.</p><h2>4. Voice User Interfaces</h2><p>Voice search and voice assistants are changing how users interact with websites. Designing for voice-first scenarios is becoming essential.</p><h2>Conclusion</h2><p>Great web design is about understanding your users and creating frictionless experiences. These trends are tools — the real magic happens when you pair them with a deep understanding of your audience.</p>",
                'excerpt' => 'Explore the latest web design trends shaping digital experiences in 2026 — from AI personalization to immersive 3D elements.',
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Laravel vs. Other PHP Frameworks: A 2026 Perspective',
                'content' => "<p>PHP continues to power a significant portion of the web, and Laravel remains the most popular PHP framework. But how does it compare to the alternatives in 2026?</p><h2>Why Laravel Stands Out</h2><p>Laravel's elegant syntax, powerful ORM (Eloquent), and rich ecosystem — including Forge, Vapor, and Nova — make it an efficient choice for developers.</p><h2>The Alternatives</h2><p>Symfony offers robust architecture for enterprise projects. CodeIgniter is lightweight but limited. CakePHP provides a structured but less modern approach.</p><h2>Our Verdict</h2><p>For most web application projects, Laravel offers the best balance of developer experience, performance, and scalability. Its large community also means you'll rarely get stuck without answers.</p>",
                'excerpt' => 'A detailed comparison of Laravel against other PHP frameworks, and why we choose it for most client projects.',
                'is_published' => true,
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'The Complete Guide to Mobile App UX',
                'content' => "<p>Creating great mobile app experiences requires a different mindset than web design. Here's what we've learned from building dozens of successful apps.</p><h2>Start With User Research</h2><p>Before you write a line of code, understand who your users are, what they need, and where the friction points exist. Personas and journey mapping are essential.</p><h2>Design for Thumbs</h2><p>Most users hold their phone in one hand and navigate with their thumb. Place key actions within the thumb's natural reach zone.</p><h2>Keep It Simple</h2><p>Mobile screens are small. Every element must earn its place. Prioritize content ruthlessly and use progressive disclosure to keep the interface clean.</p><h2>Test, Test, Test</h2><p>Usability testing with real users should happen at every stage — from paper prototypes to beta builds. Iteration is the key to mobile UX success.</p>",
                'excerpt' => 'Learn the principles of mobile app UX design that make apps feel intuitive and delightful to use.',
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'How to Choose the Right Tech Stack for Your Startup',
                'content' => "<p>Choosing the right technology stack is one of the most important decisions you'll make as a founder. Get it wrong and you'll face costly rewrites. Get it right and you'll scale smoothly.</p><h2>Consider Your Domain</h2><p>Is your product content-heavy, transaction-heavy, or community-driven? Different domains favor different technologies.</p><h2>Think About Your Team</h2><p>The best tech stack is one your team actually knows. Hiring for a niche stack is harder and more expensive than building with something your team already masters.</p><h2>Prioritize Longevity</h2><p>Choose technologies with strong communities and long-term roadmaps. You don't want to build on a framework that's about to be deprecated.</p><h2>Our Recommendation</h2><p>For most startups, we recommend a pragmatic approach: Laravel (or Django) for the backend, a modern JS framework for the frontend, and PostgreSQL for data. It covers most use cases well.</p>",
                'excerpt' => 'A practical framework for choosing a tech stack that your team can build with and scale without pain.',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Why Every Business Needs a Design System',
                'content' => "<p>A design system is more than just a collection of colors and components. It's a single source of truth that keeps your product consistent across every touchpoint.</p><h2>What Is a Design System?</h2><p>It's a complete set of standards, components, and guidelines that define how your product looks and behaves. Think of it as a shared language between designers and developers.</p><h2>The Business Case</h2><p>Design systems reduce development time, ensure accessibility compliance, and create a more cohesive brand experience. Our clients report 30-40% faster feature development after implementing one.</p><h2>Getting Started</h2><p>Start small: document your color palette, typography, and a handful of core components. Build from there as your product evolves.</p>",
                'excerpt' => 'How a well-maintained design system accelerates development and keeps your product consistent.',
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
        ];

        $admin = \App\Models\User::where('role', 'admin')->first();

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                array_merge($post, [
                    'cover_image' => null,
                    'user_id' => $admin?->id,
                ])
            );
        }
    }
}
