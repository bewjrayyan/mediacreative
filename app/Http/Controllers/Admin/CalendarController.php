<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCalendarEventRequest;
use App\Http\Requests\Admin\UpdateCalendarEventRequest;
use App\Models\CalendarEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $events = CalendarEvent::query()
            ->orderBy('starts_at')
            ->get()
            ->map(fn (CalendarEvent $event) => $event->toFullCalendar())
            ->values();

        $counts = CalendarEvent::query()
            ->selectRaw('calendar, COUNT(*) as total')
            ->groupBy('calendar')
            ->pluck('total', 'calendar');

        $upcoming = CalendarEvent::query()
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at')
            ->limit(8)
            ->get();

        $monthCount = CalendarEvent::query()
            ->whereBetween('starts_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        return view('admin.ui.calendar', [
            'calendars' => CalendarEvent::CALENDARS,
            'calendarCounts' => $counts,
            'initialEvents' => $events,
            'upcomingEvents' => $upcoming,
            'monthEventCount' => $monthCount,
        ]);
    }

    public function events(Request $request): JsonResponse
    {
        $query = CalendarEvent::query()->orderBy('starts_at');

        if ($request->filled('start')) {
            $query->where(function ($q) use ($request) {
                $q->where('starts_at', '>=', $request->date('start'))
                    ->orWhere('ends_at', '>=', $request->date('start'));
            });
        }

        if ($request->filled('end')) {
            $query->where('starts_at', '<=', $request->date('end'));
        }

        if ($request->filled('calendars')) {
            $cals = array_filter(explode(',', (string) $request->string('calendars')));
            if ($cals !== []) {
                $query->whereIn('calendar', $cals);
            }
        }

        $events = $query->get()->map(fn (CalendarEvent $event) => $event->toFullCalendar())->values();

        return response()->json($events);
    }

    public function store(StoreCalendarEventRequest $request): JsonResponse
    {
        $event = CalendarEvent::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($event->toFullCalendar(), 201);
    }

    public function update(UpdateCalendarEventRequest $request, CalendarEvent $calendarEvent): JsonResponse
    {
        $calendarEvent->update($request->validated());

        return response()->json($calendarEvent->fresh()->toFullCalendar());
    }

    public function destroy(CalendarEvent $calendarEvent): JsonResponse
    {
        $calendarEvent->delete();

        return response()->json(['ok' => true]);
    }
}
