/**
 * events-calendar.js
 * FullCalendar logic for the Event Discovery page.
 * Expects window.FanHubEvents.calendarEvents to be set by the Blade view.
 *
 * Features:
 *  - Monthly calendar grid with event dot indicators per day
 *  - Clicking a day shows that day's events in a panel below the calendar
 *  - updateCalendar() replaces all events after AJAX filter
 */

(function () {
    'use strict';

    let calendar     = null;
    let allEvents    = [];  // kept in sync so day-click can filter locally

    /**
     * Initialise FullCalendar on #event-calendar.
     * Called once when the calendar tab is first shown.
     */
    function initCalendar(events) {
        const el = document.getElementById('event-calendar');
        if (!el || calendar) return;

        if (!window.FullCalendar?.Calendar || !window.FullCalendar?.DayGrid || !window.FullCalendar?.List) {
            el.textContent = 'The calendar could not load. Check your connection and refresh the page.';
            el.setAttribute('role', 'status');
            return;
        }

        allEvents = Array.isArray(events) ? events : [];

        calendar = new FullCalendar.Calendar(el, {
            plugins: [FullCalendar.DayGrid, FullCalendar.List],
            initialView: 'dayGridMonth',
            timeZone: 'local',
            headerToolbar: {
                left:   'prev,next today',
                center: 'title',
                right:  'dayGridMonth,listMonth',
            },
            events:         allEvents,
            height:         480,
            eventColor:     '#6366f1',
            eventTextColor: '#ffffff',

            // Clicking an event navigates to its detail page
            eventClick: function (info) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            },

            /**
             * Clicking a day cell shows that day's events in the #day-events-panel
             * below the calendar without a page reload.
             */
            dateClick: function (info) {
                showDayPanel(info.dateStr);
            },
        });

        calendar.render();
    }

    /**
     * Replace all events in the calendar (called after filter AJAX).
     */
    function updateCalendar(events) {
        allEvents = Array.isArray(events) ? events : [];
        if (!calendar) { initCalendar(allEvents); return; }
        calendar.removeAllEvents();
        allEvents.forEach(function (e) { calendar.addEvent(e); });
        // Clear the day panel when filters change
        hideDayPanel();
    }

    /**
     * Show events for a specific date (YYYY-MM-DD) in the day panel.
     * Filters allEvents locally — no extra network request needed.
     */
    function showDayPanel(dateStr) {
        const panel = document.getElementById('day-events-panel');
        const title = document.getElementById('day-events-title');
        const list  = document.getElementById('day-events-list');
        if (!panel || !title || !list) return;

        // Filter events whose start date matches the clicked day
        const dayEvents = allEvents.filter(function (e) {
            return e.start && e.start.startsWith(dateStr);
        });

        // Format date for display: "Mon, 12 Jan 2026"
        const d = new Date(dateStr + 'T00:00:00');
        title.textContent = d.toLocaleDateString(undefined, { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });

        list.innerHTML = '';

        if (dayEvents.length === 0) {
            list.innerHTML = '<p class="text-gray-500 text-sm py-4 text-center">No events on this day.</p>';
        } else {
            dayEvents.forEach(function (e) {
                const item = document.createElement('a');
                item.href  = e.url || '#';
                item.className = 'flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-800 hover:bg-gray-700 border border-gray-700 transition group';
                const dot = document.createElement('span');
                dot.className = 'w-2 h-2 rounded-full bg-indigo-500 shrink-0';
                const textWrap = document.createElement('span');
                textWrap.className = 'flex-1 min-w-0';
                const eventTitle = document.createElement('span');
                eventTitle.className = 'block text-white text-sm font-medium truncate group-hover:text-indigo-300 transition';
                eventTitle.textContent = e.title || 'Event';
                textWrap.appendChild(eventTitle);
                const venue = e.extendedProps?.venue;
                const city = e.extendedProps?.city;
                if (venue || city) {
                    const location = document.createElement('span');
                    location.className = 'block text-gray-400 text-xs truncate';
                    location.textContent = [venue, city].filter(Boolean).join(', ');
                    textWrap.appendChild(location);
                }
                item.append(dot, textWrap);
                list.appendChild(item);
            });
        }

        panel.classList.remove('hidden');
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideDayPanel() {
        const panel = document.getElementById('day-events-panel');
        if (panel) panel.classList.add('hidden');
    }

    // Expose API for Alpine / external callers
    window.FanHubCalendar = { initCalendar, updateCalendar };

    // Listen for the custom event dispatched by events-map.js / Alpine
    document.addEventListener('events:updated', function (e) {
        updateCalendar(e.detail.calendarEvents);
    });
})();
