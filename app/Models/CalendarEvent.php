<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    public const CALENDARS = [
        'personal' => ['label' => 'Personal', 'color' => 'var(--purple)', 'class' => 'fc-cat-personal'],
        'work' => ['label' => 'Work', 'color' => 'var(--primary)', 'class' => 'fc-cat-work'],
        'team' => ['label' => 'Team', 'color' => 'var(--success)', 'class' => 'fc-cat-team'],
        'travel' => ['label' => 'Travel', 'color' => 'var(--info)', 'class' => 'fc-cat-travel'],
        'finance' => ['label' => 'Finance', 'color' => 'var(--warning)', 'class' => 'fc-cat-finance'],
        'birthdays' => ['label' => 'Birthdays', 'color' => 'var(--pink)', 'class' => 'fc-cat-birthday'],
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'calendar',
        'starts_at',
        'ends_at',
        'all_day',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'all_day' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toFullCalendar(): array
    {
        $meta = self::CALENDARS[$this->calendar] ?? self::CALENDARS['work'];
        $payload = [
            'id' => (string) $this->id,
            'title' => $this->title,
            'start' => $this->all_day
                ? $this->starts_at->toDateString()
                : $this->starts_at->format('Y-m-d\TH:i:s'),
            'allDay' => $this->all_day,
            'className' => $meta['class'],
            'extendedProps' => [
                'calendar' => $this->calendar,
                'description' => $this->description,
                'location' => $this->location,
            ],
        ];

        if ($this->ends_at) {
            $payload['end'] = $this->all_day
                ? $this->ends_at->toDateString()
                : $this->ends_at->format('Y-m-d\TH:i:s');
        }

        return $payload;
    }
}
