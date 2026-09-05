/**
 * Functional admin calendar — FullCalendar + Laravel CRUD API.
 * Loaded by resources/views/admin/ui/calendar.blade.php
 */
(function () {
  'use strict';

  var cfg = window.ADMINATOR_CALENDAR;
  if (!cfg || !document.getElementById('calendarMount')) return;

  var calendar = null;
  var activeCalendars = Object.keys(cfg.calendars || {});
  var modal = document.getElementById('calEventModal');
  var form = document.getElementById('calEventForm');
  var miniCursor = new Date();

  function csrfHeaders() {
    return {
      'Content-Type': 'application/json',
      Accept: 'application/json',
      'X-CSRF-TOKEN': cfg.csrf,
      'X-Requested-With': 'XMLHttpRequest',
    };
  }

  function pad(n) {
    return String(n).padStart(2, '0');
  }

  function toLocalInput(date, allDay) {
    if (!date) return '';
    var d = date instanceof Date ? date : new Date(date);
    if (Number.isNaN(d.getTime())) return '';
    if (allDay) {
      return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) + 'T00:00';
    }
    return (
      d.getFullYear() +
      '-' +
      pad(d.getMonth() + 1) +
      '-' +
      pad(d.getDate()) +
      'T' +
      pad(d.getHours()) +
      ':' +
      pad(d.getMinutes())
    );
  }

  function urlWithId(template, id) {
    return String(template).replace('__ID__', encodeURIComponent(id));
  }

  function showError(msg) {
    var el = document.getElementById('calModalError');
    if (!el) return;
    if (!msg) {
      el.hidden = true;
      el.textContent = '';
      return;
    }
    el.hidden = false;
    el.textContent = msg;
  }

  function updateTitles(date) {
    var d = date || (calendar ? calendar.getDate() : new Date());
    var month = d.toLocaleString('en-US', { month: 'long' });
    var year = d.getFullYear();
    var monthEl = document.querySelector('.cal-month');
    if (monthEl) monthEl.innerHTML = month + ' <span class="yr">' + year + '</span>';
    var heroMonth = document.getElementById('heroMonth');
    var heroYear = document.getElementById('heroYear');
    if (heroMonth) heroMonth.textContent = month;
    if (heroYear) heroYear.textContent = String(year);
    var miniTitle = document.getElementById('miniCalTitle');
    if (miniTitle) miniTitle.textContent = month + ' ' + year;
  }

  function filterEvents(events) {
    return (events || []).filter(function (ev) {
      var cal = (ev.extendedProps && ev.extendedProps.calendar) || 'work';
      return activeCalendars.indexOf(cal) !== -1;
    });
  }

  function openModal(payload) {
    payload = payload || {};
    showError('');
    document.getElementById('calModalTitle').textContent = payload.id ? 'Edit event' : 'New event';
    document.getElementById('calEventId').value = payload.id || '';
    document.getElementById('calEventTitle').value = payload.title || '';
    document.getElementById('calEventStart').value = payload.starts_at || '';
    document.getElementById('calEventEnd').value = payload.ends_at || '';
    document.getElementById('calEventCalendar').value = payload.calendar || 'work';
    document.getElementById('calEventAllDay').checked = !!payload.all_day;
    document.getElementById('calEventLocation').value = payload.location || '';
    document.getElementById('calEventDesc').value = payload.description || '';
    document.getElementById('calEventDelete').hidden = !payload.id;
    if (typeof modal.showModal === 'function') modal.showModal();
  }

  function closeModal() {
    if (modal.open) modal.close();
  }

  function eventToForm(ev) {
    var start = ev.start;
    var end = ev.end;
    return {
      id: ev.id,
      title: ev.title,
      starts_at: toLocalInput(start, ev.allDay),
      ends_at: end ? toLocalInput(end, ev.allDay) : '',
      all_day: !!ev.allDay,
      calendar: (ev.extendedProps && ev.extendedProps.calendar) || 'work',
      location: (ev.extendedProps && ev.extendedProps.location) || '',
      description: (ev.extendedProps && ev.extendedProps.description) || '',
    };
  }

  async function saveEvent(e) {
    e.preventDefault();
    showError('');
    var id = document.getElementById('calEventId').value;
    var body = {
      title: document.getElementById('calEventTitle').value.trim(),
      starts_at: document.getElementById('calEventStart').value,
      ends_at: document.getElementById('calEventEnd').value || null,
      calendar: document.getElementById('calEventCalendar').value,
      all_day: document.getElementById('calEventAllDay').checked,
      location: document.getElementById('calEventLocation').value.trim() || null,
      description: document.getElementById('calEventDesc').value.trim() || null,
    };

    if (!body.title || !body.starts_at) {
      showError('Title and start time are required.');
      return;
    }

    var url = id ? urlWithId(cfg.updateUrl, id) : cfg.storeUrl;
    var method = id ? 'PUT' : 'POST';

    try {
      var res = await fetch(url, {
        method: method,
        headers: csrfHeaders(),
        body: JSON.stringify(body),
        credentials: 'same-origin',
      });
      var data = await res.json().catch(function () {
        return {};
      });
      if (!res.ok) {
        var msg = data.message || 'Could not save event.';
        if (data.errors) {
          msg = Object.values(data.errors).flat().join(' ');
        }
        showError(msg);
        return;
      }
      closeModal();
      if (calendar) calendar.refetchEvents();
      renderMiniCal();
    } catch (err) {
      showError('Network error while saving.');
    }
  }

  async function deleteEvent() {
    var id = document.getElementById('calEventId').value;
    if (!id || !window.confirm('Delete this event?')) return;
    try {
      var res = await fetch(urlWithId(cfg.destroyUrl, id), {
        method: 'DELETE',
        headers: csrfHeaders(),
        credentials: 'same-origin',
      });
      if (!res.ok) {
        showError('Could not delete event.');
        return;
      }
      closeModal();
      if (calendar) calendar.refetchEvents();
      renderMiniCal();
    } catch (err) {
      showError('Network error while deleting.');
    }
  }

  function renderMiniCal() {
    var grid = document.getElementById('miniCalGrid');
    if (!grid) return;
    while (grid.children.length > 7) grid.removeChild(grid.lastChild);

    var y = miniCursor.getFullYear();
    var m = miniCursor.getMonth();
    var first = new Date(y, m, 1);
    var startPad = first.getDay();
    var daysInMonth = new Date(y, m + 1, 0).getDate();
    var prevDays = new Date(y, m, 0).getDate();
    var today = new Date();
    var selected = calendar ? calendar.getDate() : today;
    var eventDays = {};

    (cfg.initialEvents || []).forEach(function (ev) {
      var s = String(ev.start || '').slice(0, 10);
      if (s) eventDays[s] = true;
    });

    function addDay(day, cls, dateObj) {
      var el = document.createElement('button');
      el.type = 'button';
      el.className = 'mini-cal-day' + (cls ? ' ' + cls : '');
      el.textContent = String(day);
      var key =
        dateObj.getFullYear() +
        '-' +
        pad(dateObj.getMonth() + 1) +
        '-' +
        pad(dateObj.getDate());
      if (eventDays[key]) el.classList.add('has-event');
      if (
        dateObj.getFullYear() === today.getFullYear() &&
        dateObj.getMonth() === today.getMonth() &&
        dateObj.getDate() === today.getDate()
      ) {
        el.classList.add('is-today');
      }
      if (
        dateObj.getFullYear() === selected.getFullYear() &&
        dateObj.getMonth() === selected.getMonth() &&
        dateObj.getDate() === selected.getDate()
      ) {
        el.classList.add('is-selected');
      }
      el.addEventListener('click', function () {
        if (!calendar) return;
        calendar.gotoDate(dateObj);
        updateTitles(dateObj);
        renderMiniCal();
      });
      grid.appendChild(el);
    }

    for (var i = startPad - 1; i >= 0; i--) {
      addDay(prevDays - i, 'is-other', new Date(y, m - 1, prevDays - i));
    }
    for (var d = 1; d <= daysInMonth; d++) {
      addDay(d, '', new Date(y, m, d));
    }
    var filled = startPad + daysInMonth;
    var extra = filled % 7 === 0 ? 0 : 7 - (filled % 7);
    for (var e = 1; e <= extra; e++) {
      addDay(e, 'is-other', new Date(y, m + 1, e));
    }

    var miniTitle = document.getElementById('miniCalTitle');
    if (miniTitle) {
      miniTitle.textContent =
        miniCursor.toLocaleString('en-US', { month: 'long' }) + ' ' + miniCursor.getFullYear();
    }
  }

  function bindUi() {
    document.querySelectorAll('[data-cal-new]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var start = new Date();
        start.setMinutes(0, 0, 0);
        var end = new Date(start.getTime() + 60 * 60 * 1000);
        openModal({
          starts_at: toLocalInput(start, false),
          ends_at: toLocalInput(end, false),
          calendar: 'work',
        });
      });
    });

    document.querySelectorAll('[data-cal-nav]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (!calendar) return;
        var action = btn.getAttribute('data-cal-nav');
        if (action === 'prev') calendar.prev();
        if (action === 'next') calendar.next();
        if (action === 'today') calendar.today();
        miniCursor = new Date(calendar.getDate());
        updateTitles();
        renderMiniCal();
      });
    });

    document.querySelectorAll('[data-cal-view]').forEach(function (tab) {
      tab.addEventListener('click', function () {
        if (!calendar) return;
        document.querySelectorAll('[data-cal-view]').forEach(function (t) {
          t.classList.toggle('is-active', t === tab);
        });
        calendar.changeView(tab.getAttribute('data-cal-view'));
        updateTitles();
      });
    });

    document.querySelectorAll('[data-cal-filter]').forEach(function (item) {
      item.addEventListener('click', function () {
        var key = item.getAttribute('data-cal-filter');
        var on = item.classList.toggle('is-on');
        item.classList.toggle('is-off', !on);
        if (on) {
          if (activeCalendars.indexOf(key) === -1) activeCalendars.push(key);
        } else {
          activeCalendars = activeCalendars.filter(function (c) {
            return c !== key;
          });
        }
        if (calendar) calendar.refetchEvents();
      });
    });

    document.querySelectorAll('[data-cal-open]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (!calendar) return;
        var id = btn.getAttribute('data-cal-open');
        var ev = calendar.getEventById(id);
        if (ev) openModal(eventToForm(ev));
      });
    });

    document.getElementById('miniCalPrev')?.addEventListener('click', function () {
      miniCursor = new Date(miniCursor.getFullYear(), miniCursor.getMonth() - 1, 1);
      renderMiniCal();
    });
    document.getElementById('miniCalNext')?.addEventListener('click', function () {
      miniCursor = new Date(miniCursor.getFullYear(), miniCursor.getMonth() + 1, 1);
      renderMiniCal();
    });

    document.getElementById('calModalClose')?.addEventListener('click', closeModal);
    document.getElementById('calModalCancel')?.addEventListener('click', closeModal);
    document.getElementById('calEventDelete')?.addEventListener('click', deleteEvent);
    form?.addEventListener('submit', saveEvent);

    document.getElementById('calExportBtn')?.addEventListener('click', function () {
      if (!calendar) return;
      var rows = ['Subject,Start Date,Start Time,End Date,End Time,All Day,Calendar'];
      calendar.getEvents().forEach(function (ev) {
        var start = ev.start;
        var end = ev.end || ev.start;
        rows.push(
          [
            '"' + String(ev.title).replace(/"/g, '""') + '"',
            start ? start.toISOString().slice(0, 10) : '',
            ev.allDay || !start ? '' : start.toTimeString().slice(0, 5),
            end ? end.toISOString().slice(0, 10) : '',
            ev.allDay || !end ? '' : end.toTimeString().slice(0, 5),
            ev.allDay ? 'TRUE' : 'FALSE',
            (ev.extendedProps && ev.extendedProps.calendar) || '',
          ].join(',')
        );
      });
      var blob = new Blob([rows.join('\n')], { type: 'text/csv;charset=utf-8' });
      var a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = 'calendar-export.csv';
      a.click();
      URL.revokeObjectURL(a.href);
    });
  }

  function boot() {
    if (!window.FullCalendar) {
      setTimeout(boot, 50);
      return;
    }

    var host = document.getElementById('calendarMount');
    calendar = new FullCalendar.Calendar(host, {
      initialView: 'dayGridMonth',
      headerToolbar: false,
      height: '100%',
      expandRows: true,
      dayMaxEvents: 3,
      fixedWeekCount: false,
      firstDay: 0,
      nowIndicator: true,
      selectable: true,
      editable: true,
      eventDisplay: 'block',
      dayHeaderFormat: { weekday: 'short' },
      events: function (info, success, failure) {
        var params = new URLSearchParams({
          start: info.startStr,
          end: info.endStr,
          calendars: activeCalendars.join(','),
        });
        fetch(cfg.eventsUrl + '?' + params.toString(), {
          headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
          credentials: 'same-origin',
        })
          .then(function (r) {
            return r.json();
          })
          .then(function (events) {
            cfg.initialEvents = events;
            success(filterEvents(events));
            var countEl = document.getElementById('heroEventCount');
            if (countEl) countEl.textContent = String(filterEvents(events).length);
          })
          .catch(failure);
      },
      dateClick: function (arg) {
        var start = arg.date;
        var end = new Date(start.getTime() + 60 * 60 * 1000);
        openModal({
          starts_at: toLocalInput(start, arg.allDay),
          ends_at: toLocalInput(end, arg.allDay),
          all_day: arg.allDay,
          calendar: 'work',
        });
      },
      select: function (arg) {
        openModal({
          starts_at: toLocalInput(arg.start, arg.allDay),
          ends_at: toLocalInput(arg.end, arg.allDay),
          all_day: arg.allDay,
          calendar: 'work',
        });
        calendar.unselect();
      },
      eventClick: function (arg) {
        openModal(eventToForm(arg.event));
      },
      eventDrop: async function (arg) {
        var payload = eventToForm(arg.event);
        try {
          var res = await fetch(urlWithId(cfg.updateUrl, payload.id), {
            method: 'PUT',
            headers: csrfHeaders(),
            body: JSON.stringify({
              title: payload.title,
              starts_at: payload.starts_at,
              ends_at: payload.ends_at || null,
              all_day: payload.all_day,
              calendar: payload.calendar,
              location: payload.location || null,
              description: payload.description || null,
            }),
            credentials: 'same-origin',
          });
          if (!res.ok) arg.revert();
        } catch (err) {
          arg.revert();
        }
      },
      eventResize: async function (arg) {
        var payload = eventToForm(arg.event);
        try {
          var res = await fetch(urlWithId(cfg.updateUrl, payload.id), {
            method: 'PUT',
            headers: csrfHeaders(),
            body: JSON.stringify({
              title: payload.title,
              starts_at: payload.starts_at,
              ends_at: payload.ends_at || null,
              all_day: payload.all_day,
              calendar: payload.calendar,
              location: payload.location || null,
              description: payload.description || null,
            }),
            credentials: 'same-origin',
          });
          if (!res.ok) arg.revert();
        } catch (err) {
          arg.revert();
        }
      },
    });

    calendar.render();
    updateTitles();
    renderMiniCal();
    bindUi();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
