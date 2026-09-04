<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Alex Morgan',
                'position' => 'Founder & Creative Director',
                'bio' => 'Alex founded the agency with a vision to bridge the gap between stunning design and robust engineering. With 15+ years in the industry, Alex leads our creative vision.',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/alexmorgan',
                    'twitter' => 'https://twitter.com/alexmorgan',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Jordan Lee',
                'position' => 'Lead Full-Stack Developer',
                'bio' => 'Jordan is a veteran developer specializing in Laravel and modern JavaScript frameworks. He has delivered 50+ production applications and leads our engineering team.',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/jordanlee',
                    'github' => 'https://github.com/jordanlee',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Priya Sharma',
                'position' => 'Senior UI/UX Designer',
                'bio' => 'Priya brings a user-first approach to every project. Her design systems have powered products used by millions. She specializes in complex enterprise applications.',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/priyasharma',
                    'twitter' => 'https://twitter.com/priyadesigns',
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'Tom Williams',
                'position' => 'Project Manager',
                'bio' => 'Tom keeps our projects on track with his meticulous planning and clear communication. He ensures every deliverable exceeds client expectations.',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/tomwilliams',
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                array_merge($member, [
                    'photo' => null,
                    'is_active' => true,
                ])
            );
        }
    }
}
