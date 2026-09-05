<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\CalendarEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCalendarEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:2000'],
            'calendar' => ['sometimes', 'required', 'string', Rule::in(array_keys(CalendarEvent::CALENDARS))],
            'starts_at' => ['sometimes', 'required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'all_day' => ['sometimes', 'boolean'],
            'location' => ['nullable', 'string', 'max:180'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('all_day')) {
            $this->merge(['all_day' => $this->boolean('all_day')]);
        }
    }
}
