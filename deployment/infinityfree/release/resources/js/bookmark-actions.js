function showBookmarkNotice(message, isError = false) {
    let notice = document.getElementById('bookmark-action-notice');
    if (!notice) {
        notice = document.createElement('div');
        notice.id = 'bookmark-action-notice';
        notice.setAttribute('role', 'status');
        notice.setAttribute('aria-live', 'polite');
        Object.assign(notice.style, {
            position: 'fixed', right: '1.25rem', bottom: '1.25rem', zIndex: '99999',
            maxWidth: 'min(24rem, calc(100vw - 2.5rem))', padding: '.8rem 1rem',
            borderRadius: '.8rem', color: '#fff', fontWeight: '600',
            boxShadow: '0 12px 36px rgba(0,0,0,.35)', transition: 'opacity .2s ease',
        });
        document.body.append(notice);
    }
    notice.textContent = message;
    notice.style.background = isError ? '#991b1b' : '#5b21b6';
    notice.style.opacity = '1';
    clearTimeout(notice.hideTimer);
    notice.hideTimer = setTimeout(() => { notice.style.opacity = '0'; }, 2600);
}

async function postBookmark(button, csrfToken) {
    return fetch(button.dataset.bookmarkUrl, {
        method: 'POST',
        credentials: 'same-origin',
        cache: 'no-store',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    });
}

document.addEventListener('click', async (event) => {
    const button = event.target instanceof Element ? event.target.closest('.bookmark-toggle') : null;
    if (!button) return;

    event.preventDefault();
    event.stopPropagation();
    if (button.disabled) return;

    const wasBookmarked = button.dataset.bookmarked === 'true';
    button.disabled = true;

    try {
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        let response = await postBookmark(button, csrfMeta?.content ?? '');

        // A page left open through session rotation can hold an old token.
        // Fetch this page once to refresh the session cookie and CSRF token,
        // then retry the same authenticated request.
        if (response.status === 419) {
            const pageResponse = await fetch(window.location.href, {
                credentials: 'same-origin',
                cache: 'no-store',
                headers: { 'Accept': 'text/html' },
            });
            if (pageResponse.ok) {
                const pageMarkup = await pageResponse.text();
                const freshToken = new DOMParser()
                    .parseFromString(pageMarkup, 'text/html')
                    .querySelector('meta[name="csrf-token"]')?.content;
                if (freshToken && csrfMeta) {
                    csrfMeta.content = freshToken;
                    response = await postBookmark(button, freshToken);
                }
            }
        }

        if (response.status === 401) {
            showBookmarkNotice('Your sign-in expired. Opening sign in…', true);
            window.setTimeout(() => { window.location.assign('/login'); }, 700);
            return;
        }
        if (response.status === 419) {
            throw new Error('Your session token is still invalid. Refresh the page and sign in again.');
        }
        if (!response.ok) {
            throw new Error(`Bookmark could not be saved (${response.status}).`);
        }
        const result = await response.json();
        const isBookmarked = result.bookmarked === true;

        document.querySelectorAll(`.bookmark-toggle[data-content-id="${CSS.escape(button.dataset.contentId)}"]`).forEach((control) => {
            control.dataset.bookmarked = String(isBookmarked);
            control.setAttribute('aria-pressed', String(isBookmarked));
            control.setAttribute('aria-label', isBookmarked ? 'Remove bookmark' : 'Save bookmark');
            control.title = isBookmarked ? 'Remove bookmark' : 'Save to bookmarks';
            control.querySelector('.bookmark-icon')?.setAttribute('fill', isBookmarked ? 'currentColor' : 'none');
            const label = control.querySelector('.bookmark-label');
            if (label) label.textContent = isBookmarked ? 'Saved' : 'Save bookmark';
        });

        if (wasBookmarked && !isBookmarked && window.location.pathname.replace(/\/$/, '') === '/bookmarks') {
            const card = button.closest('.fh-content-card');
            const grid = card?.parentElement;
            card?.remove();
            if (grid && !grid.querySelector('.fh-content-card')) window.location.reload();
        }
        showBookmarkNotice(isBookmarked ? 'Saved to your bookmarks.' : 'Removed from your bookmarks.');
    } catch (error) {
        button.title = error.message || 'Could not save bookmark. Please try again.';
        button.setAttribute('aria-label', button.title);
        showBookmarkNotice(button.title, true);
    } finally {
        button.disabled = false;
    }
}, true);

// Home uses a few hand-built media cards; give them the same saved-item control
// as the shared content-card and carousel components.
document.querySelectorAll('.fh-card').forEach((card) => {
    const media = card.querySelector('.fh-card__media');
    const myListButton = card.querySelector('.mylist-btn[data-content-id]');
    const linkedContentId = card.href?.match(/\/contents\/(\d+)/)?.[1];
    const contentId = myListButton?.dataset.contentId || card.dataset.contentId || linkedContentId;
    if (!media || !contentId || card?.querySelector('.bookmark-toggle')) return;

    const bookmarkedIds = (window.fhBookmarkedContentIds || []).map(String);
    const isBookmarked = bookmarkedIds.includes(String(contentId));
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'fh-card__bookmark bookmark-toggle';
    button.dataset.contentId = contentId;
    button.dataset.bookmarkUrl = `/bookmarks/${encodeURIComponent(contentId)}/toggle`;
    button.dataset.bookmarked = String(isBookmarked);
    button.setAttribute('aria-label', isBookmarked ? 'Remove bookmark' : 'Save bookmark');
    button.setAttribute('aria-pressed', String(isBookmarked));
    button.title = isBookmarked ? 'Remove bookmark' : 'Save to bookmarks';
    button.innerHTML = '<svg class="bookmark-icon" fill="' + (isBookmarked ? 'currentColor' : 'none') + '" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg><span class="bookmark-label">' + (isBookmarked ? 'Saved' : 'Bookmark') + '</span>';
    media.append(button);
});
