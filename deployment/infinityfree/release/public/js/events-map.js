/** Event map rendering and geographic event markers. */
(function () {
    'use strict';

    const cfg = window.FanHubEvents || {};
    const mapElement = document.getElementById('events-map');
    const countElement = document.getElementById('map-event-count');
    let map = null;
    let markerLayer = null;
    let userMarker = null;

    function validCoordinates(lat, lng) {
        if (lat === null || lat === undefined || lat === '' || lng === null || lng === undefined || lng === '') return false;
        return Number.isFinite(Number(lat)) && Number.isFinite(Number(lng))
            && Number(lat) >= -90 && Number(lat) <= 90
            && Number(lng) >= -180 && Number(lng) <= 180;
    }

    function initializeMap(events) {
        if (!mapElement || map) return;
        if (!window.L) {
            mapElement.textContent = 'The event map could not load. Check your connection and refresh the page.';
            mapElement.setAttribute('role', 'status');
            mapElement.classList.add('grid', 'place-items-center', 'p-6', 'text-center', 'text-gray-300');
            return;
        }

        const defaultLocation = cfg.defaultLocation || {};
        const defaultCoords = validCoordinates(defaultLocation.latitude, defaultLocation.longitude)
            ? [Number(defaultLocation.latitude), Number(defaultLocation.longitude)] : null;
        const eventList = Array.isArray(events) ? events : [];
        const firstEvent = eventList.find(event => event && validCoordinates(event.lat, event.lng));
        map = L.map(mapElement, { scrollWheelZoom: false });
        if (defaultCoords) map.setView(defaultCoords, 11);
        else if (firstEvent) map.setView([Number(firstEvent.lat), Number(firstEvent.lng)], 11);
        else map.fitWorld();
        const tileStatus = document.createElement('div');
        tileStatus.textContent = 'Map tiles could not be loaded. Check your internet connection.';
        Object.assign(tileStatus.style, {
            display: 'none', position: 'absolute', zIndex: '1000', left: '12px', bottom: '12px',
            maxWidth: 'calc(100% - 24px)', padding: '8px 12px', borderRadius: '8px',
            color: '#fff', background: 'rgba(17, 17, 27, .92)', fontSize: '12px',
        });
        mapElement.appendChild(tileStatus);

        const osmTiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap contributors</a>',
            maxZoom: 19,
        }).addTo(map);
        osmTiles.on('tileerror', () => { tileStatus.style.display = 'block'; });
        markerLayer = L.layerGroup().addTo(map);
        window.setTimeout(() => map.invalidateSize(), 0);
    }

    function renderMarkers(events) {
        const available = (Array.isArray(events) ? events : []).filter(event => event && validCoordinates(event.lat, event.lng));
        if (countElement) countElement.textContent = String(available.length);
        initializeMap(available);
        if (!map || !markerLayer) return;

        markerLayer.clearLayers();
        available.forEach(event => {
            const marker = L.marker([Number(event.lat), Number(event.lng)]);
            const popup = document.createElement('div');
            const title = document.createElement('strong');
            title.textContent = event.title || 'Event';
            popup.appendChild(title);

            const details = document.createElement('p');
            details.textContent = [event.date, event.venue, event.city, event.category].filter(Boolean).join(' · ');
            popup.appendChild(details);

            const country = document.createElement('p');
            country.textContent = event.country || '';
            if (country.textContent) popup.appendChild(country);

            if (event.description) {
                const description = document.createElement('p');
                description.textContent = String(event.description).replace(/\s+/g, ' ').slice(0, 180);
                popup.appendChild(description);
            }

            if (event.url) {
                const link = document.createElement('a');
                link.href = event.url;
                link.textContent = 'View event';
                link.className = 'text-indigo-600 underline';
                popup.appendChild(link);
            }
            if (event.ticket_link) {
                const ticket = document.createElement('a');
                ticket.href = event.ticket_link;
                ticket.target = '_blank';
                ticket.rel = 'noopener noreferrer';
                ticket.textContent = ' · Get tickets';
                popup.appendChild(ticket);
            }
            marker.bindPopup(popup).addTo(markerLayer);
        });

        if (!userMarker && available.length) {
            const bounds = markerLayer.getBounds();
            if (bounds.isValid()) map.fitBounds(bounds.pad(0.18), { maxZoom: 13 });
        }
        window.setTimeout(() => map.invalidateSize(), 0);
    }

    function setUserLocation(lat, lng) {
        if (!validCoordinates(lat, lng)) return;
        initializeMap(cfg.mapEvents || []);
        if (!map) return;
        if (userMarker) userMarker.remove();
        userMarker = L.circleMarker([Number(lat), Number(lng)], {
            radius: 8,
            color: '#f0abfc',
            weight: 2,
            fillColor: '#a855f7',
            fillOpacity: 0.95,
        }).bindPopup('Your selected location').addTo(map);
        map.setView([Number(lat), Number(lng)], 10);
    }

    function flyToCity(lat, lng) {
        if (!validCoordinates(lat, lng)) return;
        initializeMap(Array.isArray(cfg.mapEvents) ? cfg.mapEvents : []);
        if (map) map.flyTo([Number(lat), Number(lng)], 11, { duration: 0.8 });
    }

    window.FanHubMap = { renderMarkers, setUserLocation, flyToCity };
    renderMarkers(Array.isArray(cfg.mapEvents) ? cfg.mapEvents : []);
})();
