@extends('admin.layouts.app')

@php
  $now = now();
  $monthLabel = $now->format('F');
  $yearLabel = $now->format('Y');
@endphp

@section('title', $monthLabel.' '.$yearLabel)
@section('active', 'calendar')
@section('crumbs', 'Communications | Calendar | '.$monthLabel.' '.$yearLabel)

@section('content')
<section class="hero cal-hero">
  <div class="hero-text">
    <span class="eyebrow" id="heroDate">{{ $now->format('l · F j · Y') }}</span>
    <h1 class="hero-title"><span id="heroMonth">{{ $monthLabel }}</span> <span class="accent" id="heroYear">{{ $yearLabel }}</span></h1>
    <p class="hero-sub"><strong id="heroEventCount">{{ $monthEventCount }}</strong> events this month · manage meetings, travel, and deadlines here.</p>
  </div>
  <div class="hero-actions">
    <button type="button" class="btn btn--ghost" id="calExportBtn">
      <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
      Export
    </button>
    <button type="button" class="btn btn--primary" data-cal-new>
      <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
      New event
    </button>
  </div>
</section>

<section class="cal-shell" aria-label="Calendar">
  <aside class="cal-rail">
    <button type="button" class="cal-quickadd" data-cal-new>
      <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
      Quick add event
    </button>

    <div class="cal-rail-card">
      <div class="cal-rail-head">
        <div class="cal-rail-title" id="miniCalTitle">{{ $monthLabel }} {{ $yearLabel }}</div>
        <div class="cal-rail-tools">
          <button type="button" class="mail-tool" id="miniCalPrev" aria-label="Previous month" style="width: 24px; height: 24px;">
            <svg viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path d="m15 18-6-6 6-6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
          </button>
          <button type="button" class="mail-tool" id="miniCalNext" aria-label="Next month" style="width: 24px; height: 24px;">
            <svg viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path d="m9 18 6-6-6-6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
          </button>
        </div>
      </div>
      <div class="mini-cal-grid" id="miniCalGrid">
        <div class="mini-cal-wd">S</div><div class="mini-cal-wd">M</div><div class="mini-cal-wd">T</div><div class="mini-cal-wd">W</div><div class="mini-cal-wd">T</div><div class="mini-cal-wd">F</div><div class="mini-cal-wd">S</div>
      </div>
    </div>

    <div class="cal-rail-card">
      <div class="cal-rail-head">
        <div class="cal-rail-title">My calendars</div>
      </div>
      <div class="cal-list" id="calFilterList">
        @foreach($calendars as $key => $meta)
        <button type="button" class="cal-list-item is-on" data-cal-filter="{{ $key }}">
          <span class="cal-list-check" style="color: {{ $meta['color'] }};"></span>
          <span class="cal-list-name">{{ $meta['label'] }}</span>
          <span class="cal-list-count">{{ (int) ($calendarCounts[$key] ?? 0) }}</span>
        </button>
        @endforeach
      </div>
    </div>

    <div class="cal-rail-card">
      <div class="cal-rail-head">
        <div class="cal-rail-title">Upcoming</div>
      </div>
      <div class="upc-list" id="upcList">
        @forelse($upcomingEvents as $event)
        @php $meta = $calendars[$event->calendar] ?? $calendars['work']; @endphp
        <button type="button" class="upc-item" data-cal-open="{{ $event->id }}">
          <div class="upc-date {{ $event->starts_at->isToday() ? 'is-today' : '' }}">
            <div class="day">{{ $event->starts_at->format('j') }}</div>
            <span class="mo">{{ $event->starts_at->format('M') }}</span>
          </div>
          <div class="upc-meta">
            <div class="upc-title">{{ $event->title }}</div>
            <div class="upc-time">
              <span class="dot" style="background: {{ $meta['color'] }};"></span>
              <span class="mono">{{ $event->all_day ? 'All day' : $event->starts_at->format('H:i') }}</span>
              <span>· {{ $meta['label'] }}</span>
            </div>
          </div>
        </button>
        @empty
        <div class="upc-empty" style="padding:12px;font-size:12.5px;color:var(--t-muted);">No upcoming events. Create one to get started.</div>
        @endforelse
      </div>
    </div>
  </aside>

  <section class="cal-main">
    <div class="cal-toolbar">
      <div class="cal-toolbar-left">
        <div class="cal-month">{{ $monthLabel }} <span class="yr">{{ $yearLabel }}</span></div>
        <div class="cal-nav">
          <button type="button" class="cal-nav-btn" data-cal-nav="prev" aria-label="Previous">
            <svg viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
          </button>
          <button type="button" class="cal-today-btn" data-cal-nav="today">Today</button>
          <button type="button" class="cal-nav-btn" data-cal-nav="next" aria-label="Next">
            <svg viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>
      </div>
      <div class="cal-views">
        <button type="button" class="cal-view-tab" data-cal-view="timeGridDay">Day</button>
        <button type="button" class="cal-view-tab" data-cal-view="timeGridWeek">Week</button>
        <button type="button" class="cal-view-tab is-active" data-cal-view="dayGridMonth">Month</button>
        <button type="button" class="cal-view-tab" data-cal-view="listWeek">Agenda</button>
      </div>
      <div class="cal-toolbar-right">
        <button type="button" class="btn btn--primary" style="padding: 7px 12px; font-size: 12px;" data-cal-new>
          <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
          New event
        </button>
      </div>
    </div>

    <div id="calendarMount" style="flex: 1; min-height: 540px;"></div>
  </section>
</section>

<dialog class="cal-modal" id="calEventModal">
  <form method="dialog" id="calEventForm" class="cal-modal__panel">
    <header class="cal-modal__head">
      <h2 class="cal-modal__title" id="calModalTitle">New event</h2>
      <button type="button" class="cal-modal__close" id="calModalClose" aria-label="Close">&times;</button>
    </header>
    <div class="cal-modal__body">
      <input type="hidden" name="id" id="calEventId">
      <label class="saas-label" for="calEventTitle">Title</label>
      <input class="saas-input" id="calEventTitle" name="title" required maxlength="180" placeholder="Event title">

      <div class="saas-row saas-row--2" style="margin-top:12px">
        <div>
          <label class="saas-label" for="calEventStart">Starts</label>
          <input class="saas-input" type="datetime-local" id="calEventStart" name="starts_at" required>
        </div>
        <div>
          <label class="saas-label" for="calEventEnd">Ends</label>
          <input class="saas-input" type="datetime-local" id="calEventEnd" name="ends_at">
        </div>
      </div>

      <div class="saas-row saas-row--2" style="margin-top:12px">
        <div>
          <label class="saas-label" for="calEventCalendar">Calendar</label>
          <select class="saas-input" id="calEventCalendar" name="calendar">
            @foreach($calendars as $key => $meta)
              <option value="{{ $key }}">{{ $meta['label'] }}</option>
            @endforeach
          </select>
        </div>
        <div style="display:flex;align-items:flex-end;padding-bottom:8px">
          <label class="saas-check" style="width:100%">
            <input type="checkbox" id="calEventAllDay" name="all_day" value="1">
            <span>All-day event</span>
          </label>
        </div>
      </div>

      <label class="saas-label" for="calEventLocation" style="margin-top:12px">Location</label>
      <input class="saas-input" id="calEventLocation" name="location" maxlength="180" placeholder="Optional">

      <label class="saas-label" for="calEventDesc" style="margin-top:12px">Notes</label>
      <textarea class="saas-textarea" id="calEventDesc" name="description" rows="3" placeholder="Optional notes"></textarea>
      <p class="cal-modal__error" id="calModalError" hidden></p>
    </div>
    <footer class="cal-modal__foot">
      <button type="button" class="btn btn--ghost" id="calEventDelete" hidden>Delete</button>
      <div style="flex:1"></div>
      <button type="button" class="btn btn--ghost" id="calModalCancel">Cancel</button>
      <button type="submit" class="btn btn--primary" id="calEventSave">Save event</button>
    </footer>
  </form>
</dialog>
@endsection

@push('styles')
<style>
  .cal-list-item { width: 100%; border: 0; background: transparent; cursor: pointer; text-align: left; font: inherit; }
  .cal-list-item.is-off { opacity: .45; }
  .upc-item { width: 100%; border: 0; background: transparent; cursor: pointer; text-align: left; font: inherit; }
  .cal-quickadd { width: 100%; border: 0; cursor: pointer; font: inherit; text-align: left; }
  .cal-modal { border: 0; padding: 0; background: transparent; max-width: 520px; width: calc(100% - 32px); }
  .cal-modal::backdrop { background: rgba(15, 23, 42, .45); backdrop-filter: blur(4px); }
  .cal-modal__panel {
    background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px;
    box-shadow: var(--shadow-lg); overflow: hidden;
  }
  .cal-modal__head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 16px 18px; border-bottom: 1px solid var(--border); }
  .cal-modal__title { margin: 0; font-size: 16px; font-weight: 750; }
  .cal-modal__close { border: 0; background: transparent; font-size: 24px; line-height: 1; cursor: pointer; color: var(--t-muted); }
  .cal-modal__body { padding: 16px 18px 8px; }
  .cal-modal__foot { display: flex; align-items: center; gap: 8px; padding: 12px 18px 16px; border-top: 1px solid var(--border); }
  .cal-modal__error { color: var(--danger); font-size: 13px; margin: 10px 0 0; }
  .mini-cal-day { cursor: pointer; }
  .mini-cal-day.is-selected { background: var(--primary-soft); color: var(--primary); font-weight: 700; }
</style>
@endpush

@push('scripts')
<script>
  window.ADMINATOR_CALENDAR = {
    eventsUrl: @json(route('admin.calendar.events')),
    storeUrl: @json(route('admin.calendar.events.store')),
    updateUrl: @json(route('admin.calendar.events.update', ['calendarEvent' => '__ID__'])),
    destroyUrl: @json(route('admin.calendar.events.destroy', ['calendarEvent' => '__ID__'])),
    csrf: @json(csrf_token()),
    initialEvents: @json($initialEvents),
    calendars: @json($calendars),
  };
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js" defer></script>
<script defer src="{{ asset('adminator/js/calendar-app.js') }}?v={{ config('app.version') }}"></script>
@endpush
