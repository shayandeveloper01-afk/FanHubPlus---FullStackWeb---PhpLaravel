/**
 * FanHub+ Analytics Beacon
 *
 * Privacy note: no PII is collected. Only event_type, an anonymous
 * session_id (generated in localStorage — not tied to any user account),
 * and non-PII metadata (content_id, faq_id, etc.) are sent.
 * See AnalyticsLogger.php for server-side privacy notes.
 */
(function () {
    'use strict';

    const ENDPOINT = '/analytics/track';
    const CSRF     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    // Anonymous session ID — persisted in localStorage, never tied to a user account
    let sessionId = localStorage.getItem('fh_sid');
    if (!sessionId) {
        sessionId = crypto.randomUUID ? crypto.randomUUID()
            : Math.random().toString(36).slice(2) + Date.now().toString(36);
        localStorage.setItem('fh_sid', sessionId);
    }

    /**
     * Send an analytics event.
     * Uses sendBeacon when available (fire-and-forget on page unload),
     * falls back to fetch with keepalive for richer payloads.
     */
    function track(eventType, metadata) {
        const payload = JSON.stringify({
            event_type: eventType,
            session_id: sessionId,
            metadata:   metadata ?? {},
            _token:     CSRF,
        });

        const blob = new Blob([payload], { type: 'application/json' });

        if (navigator.sendBeacon) {
            navigator.sendBeacon(ENDPOINT, blob);
        } else {
            fetch(ENDPOINT, {
                method:    'POST',
                keepalive: true,
                headers:   { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:      payload,
            }).catch(() => {}); // best-effort
        }
    }

    // ── Page view ─────────────────────────────────────────────────────────────
    track('page_view', { url: location.pathname });

    // ── Content clicks ────────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        // Content card link
        const contentLink = e.target.closest('[data-content-id]');
        if (contentLink && contentLink.tagName === 'A') {
            track('content_click', { content_id: contentLink.dataset.contentId });
        }

        // My List button
        const myListBtn = e.target.closest('.mylist-btn');
        if (myListBtn) {
            const adding = myListBtn.dataset.inList !== 'true';
            if (adding) {
                track('my_list_added', { content_id: myListBtn.dataset.contentId });
            }
        }

        // RSVP button (any button/link with data-rsvp)
        const rsvpBtn = e.target.closest('[data-rsvp]');
        if (rsvpBtn) {
            track('event_rsvp_click', { event_id: rsvpBtn.dataset.rsvp });
        }
    });

    // ── Trailer hover ─────────────────────────────────────────────────────────
    document.querySelectorAll('[data-trailer][data-content-id]').forEach(function (card) {
        let fired = false;
        card.addEventListener('mouseenter', function () {
            if (!fired) {
                fired = true;
                track('trailer_hover', { content_id: card.dataset.contentId });
            }
        });
    });

    // ── Chatbot open ──────────────────────────────────────────────────────────
    // Fires when the chatbot toggle button is clicked (button has data-chatbot-toggle)
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-chatbot-toggle]')) {
            track('chatbot_opened', {});
        }
    });

    // Expose globally so inline scripts can call window.fhTrack(...)
    window.fhTrack = track;
})();
