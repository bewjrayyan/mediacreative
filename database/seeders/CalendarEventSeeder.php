<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class CalendarEventSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');
        $year = (int) now()->format('Y');
        $month = (int) now()->format('m');
        $pad = static fn (int $d): string => sprintf('%04d-%02d-%02d', $year, $month, $d);

        $seeds = [
            ['title' => 'Team standup', 'calendar' => 'work', 'day' => max(1, (int) now()->format('d') - 1), 'time' => '10:00', 'all_day' => false],
            ['title' => 'Client call', 'calendar' => 'work', 'day' => (int) now()->format('d'), 'time' => '14:00', 'all_day' => false],
            ['title' => 'Design review', 'calendar' => 'team', 'day' => min(28, (int) now()->format('d') + 2), 'time' => '11:00', 'all_day' => false],
            ['title' => 'Sprint planning', 'calendar' => 'work', 'day' => min(28, (int) now()->format('d') + 3), 'time' => '10:00', 'all_day' => false],
            ['title' => 'Personal focus block', 'calendar' => 'personal', 'day' => min(28, (int) now()->format('d') + 1), 'time' => '09:00', 'all_day' => false],
            ['title' => 'Invoice deadline', 'calendar' => 'finance', 'day' => min(28, 15), 'time' => null, 'all_day' => true],
            ['title' => 'Offsite travel', 'calendar' => 'travel', 'day' => min(25, (int) now()->format('d') + 5), 'time' => null, 'all_day' => true, 'end_day' => min(28, (int) now()->format('d') + 7)],
        ];

        foreach ($seeds as $seed) {
            $startDate = $pad((int) $seed['day']);
            $startsAt = $seed['all_day']
                ? $startDate.' 00:00:00'
                : $startDate.' '.$seed['time'].':00';

            $endsAt = null;
            if (! empty($seed['end_day'])) {
                $endsAt = $pad((int) $seed['end_day']).' 00:00:00';
            } elseif (! $seed['all_day'] && $seed['time']) {
                $endsAt = $startDate.' '.sprintf('%02d', ((int) substr($seed['time'], 0, 2)) + 1).substr($seed['time'], 2).':00';
            }

            CalendarEvent::query()->updateOrCreate(
                [
                    'title' => $seed['title'],
                    'starts_at' => $startsAt,
                ],
                [
                    'user_id' => $userId,
                    'calendar' => $seed['calendar'],
                    'all_day' => $seed['all_day'],
                    'ends_at' => $endsAt,
                    'description' => null,
                    'location' => null,
                ]
            );
        }
    }
}
