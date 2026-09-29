<div class="fh-notification-menu" x-data="{ open: false }">
    <button type="button" class="fh-notification-toggle" @click="open = !open"
            @keydown.escape="open = false" :aria-expanded="open" aria-controls="fh-notifications-panel"
            aria-label="Open notifications" title="Notifications">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .53-.21 1.04-.59 1.41L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
        </svg>
    </button>

    <section id="fh-notifications-panel" x-show="open" x-cloak @click.outside="open = false"
             class="fh-notifications-panel" role="region" aria-label="Notifications">
        <div class="fh-notifications-panel__heading">
            <h2>Notifications</h2>
            <button type="button" @click="open = false" aria-label="Close notifications">&times;</button>
        </div>
        <div class="fh-notifications-empty">
            <span class="fh-notifications-empty__icon" aria-hidden="true">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                          d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .53-.21 1.04-.59 1.41L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
                </svg>
            </span>
            <p class="fh-notifications-empty__title">You're all caught up</p>
            <p class="fh-notifications-empty__copy">New updates will appear here.</p>
            <div class="fh-notifications-panel__links">
                <a href="{{ route('explore') }}">Explore content</a>
                <a href="{{ route('events.index') }}">Browse events</a>
            </div>
        </div>
    </section>
</div>
