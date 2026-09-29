/**
 * fh-ux.js — FanHub+ UX upgrade
 * Features: top-bar, toast, confirm dialog, keyboard shortcuts
 * Vanilla JS only. All classes/ids prefixed fh-.
 */

/* ═══════════════════════════════════════════════════════════════════════════
   1. TOP LOADING BAR
   ═══════════════════════════════════════════════════════════════════════════ */
const FhTopBar = (function () {
    let bar, timer, width = 0;

    function init() {
        bar = document.createElement('div');
        bar.className = 'fh-top-bar';
        bar.setAttribute('role', 'progressbar');
        bar.setAttribute('aria-hidden', 'true');
        document.body.prepend(bar);
    }

    function set(pct) {
        width = pct;
        bar.style.width = pct + '%';
        bar.style.opacity = '1';
    }

    function start() {
        clearInterval(timer);
        set(0);
        let current = 0;
        timer = setInterval(function () {
            // Trickle: fast to 70%, slow to 90%
            const inc = current < 70 ? 8 : current < 90 ? 2 : 0.5;
            current = Math.min(current + inc, 90);
            set(current);
        }, 120);
    }

    function done() {
        clearInterval(timer);
        set(100);
        setTimeout(function () {
            bar.classList.add('fh-top-bar--done');
            setTimeout(function () {
                set(0);
                bar.classList.remove('fh-top-bar--done');
            }, 400);
        }, 200);
    }

    function fail() {
        clearInterval(timer);
        bar.style.background = 'var(--fh-error)';
        set(100);
        setTimeout(function () {
            bar.classList.add('fh-top-bar--done');
            setTimeout(function () {
                set(0);
                bar.style.background = '';
                bar.classList.remove('fh-top-bar--done');
            }, 400);
        }, 600);
    }

    return { init, start, done, fail };
})();

/* ═══════════════════════════════════════════════════════════════════════════
   2. TOAST NOTIFICATION SYSTEM
   ═══════════════════════════════════════════════════════════════════════════ */
const FhToast = (function () {
    let region;

    const ICONS = {
        success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        error:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        warning: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    };

    function init() {
        region = document.createElement('div');
        region.className = 'fh-toast-region';
        region.setAttribute('aria-live', 'polite');
        region.setAttribute('aria-atomic', 'false');
        region.setAttribute('role', 'region');
        region.setAttribute('aria-label', 'Notifications');
        document.body.appendChild(region);
    }

    /**
     * Show a toast.
     * @param {Object} opts
     * @param {string} opts.type    — 'success' | 'error' | 'warning' | 'info'
     * @param {string} opts.title   — bold line
     * @param {string} [opts.msg]   — optional second line
     * @param {number} [opts.duration] — ms, default 4000. 0 = sticky
     */
    function show(opts) {
        const type     = opts.type || 'info';
        const duration = opts.duration !== undefined ? opts.duration : 4000;

        const toast = document.createElement('div');
        toast.className = 'fh-toast fh-toast--' + type;
        toast.setAttribute('role', 'alert');
        toast.innerHTML =
            '<span class="fh-toast__bar"></span>' +
            '<span class="fh-toast__icon">' + (ICONS[type] || ICONS.info) + '</span>' +
            '<div class="fh-toast__body">' +
                '<div class="fh-toast__title">' + _esc(opts.title) + '</div>' +
                (opts.msg ? '<div class="fh-toast__msg">' + _esc(opts.msg) + '</div>' : '') +
            '</div>' +
            '<button class="fh-toast__close" aria-label="Dismiss">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
            '</button>' +
            (duration > 0 ? '<div class="fh-toast__progress" style="animation-duration:' + duration + 'ms"></div>' : '');

        region.appendChild(toast);

        toast.querySelector('.fh-toast__close').addEventListener('click', function () {
            dismiss(toast);
        });

        if (duration > 0) {
            setTimeout(function () { dismiss(toast); }, duration);
        }

        return toast;
    }

    function dismiss(toast) {
        if (!toast || !toast.parentNode) return;
        toast.classList.add('fh-toast--leaving');
        toast.addEventListener('animationend', function () {
            toast.remove();
        }, { once: true });
    }

    function _esc(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // Convenience methods
    function success(title, msg, duration) { return show({ type: 'success', title, msg, duration }); }
    function error(title, msg, duration)   { return show({ type: 'error',   title, msg, duration }); }
    function warning(title, msg, duration) { return show({ type: 'warning', title, msg, duration }); }
    function info(title, msg, duration)    { return show({ type: 'info',    title, msg, duration }); }

    return { init, show, dismiss, success, error, warning, info };
})();

/* ═══════════════════════════════════════════════════════════════════════════
   3. CONFIRM DIALOG (replaces window.confirm)
   ═══════════════════════════════════════════════════════════════════════════ */
const FhConfirm = (function () {
    const ICONS = {
        danger:  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>',
        warning: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
    };

    /**
     * Show a confirm dialog. Returns a Promise<boolean>.
     * @param {Object} opts
     * @param {string} opts.title
     * @param {string} [opts.msg]
     * @param {string} [opts.type]        — 'danger' | 'warning' | 'info'
     * @param {string} [opts.confirmText] — default 'Confirm'
     * @param {string} [opts.cancelText]  — default 'Cancel'
     */
    function show(opts) {
        return new Promise(function (resolve) {
            const type        = opts.type || 'danger';
            const confirmText = opts.confirmText || 'Confirm';
            const cancelText  = opts.cancelText  || 'Cancel';

            const backdrop = document.createElement('div');
            backdrop.className = 'fh-confirm-backdrop';
            backdrop.setAttribute('role', 'dialog');
            backdrop.setAttribute('aria-modal', 'true');
            backdrop.setAttribute('aria-labelledby', 'fh-confirm-title');

            backdrop.innerHTML =
                '<div class="fh-confirm-dialog">' +
                    '<div class="fh-confirm-dialog__icon fh-confirm-dialog__icon--' + type + '">' +
                        (ICONS[type] || ICONS.warning) +
                    '</div>' +
                    '<div class="fh-confirm-dialog__title" id="fh-confirm-title">' + _esc(opts.title) + '</div>' +
                    (opts.msg ? '<div class="fh-confirm-dialog__msg">' + _esc(opts.msg) + '</div>' : '') +
                    '<div class="fh-confirm-dialog__actions">' +
                        '<button class="fh-confirm-dialog__btn fh-confirm-dialog__btn--cancel" data-action="cancel">' + _esc(cancelText) + '</button>' +
                        '<button class="fh-confirm-dialog__btn fh-confirm-dialog__btn--confirm-' + (type === 'danger' ? 'danger' : 'primary') + '" data-action="confirm">' + _esc(confirmText) + '</button>' +
                    '</div>' +
                '</div>';

            document.body.appendChild(backdrop);

            // Focus confirm button
            const confirmBtn = backdrop.querySelector('[data-action="confirm"]');
            const cancelBtn  = backdrop.querySelector('[data-action="cancel"]');
            confirmBtn.focus();

            function close(result) {
                backdrop.style.animation = 'fh-confirm-bg-in .2s ease reverse both';
                setTimeout(function () { backdrop.remove(); }, 200);
                resolve(result);
            }

            confirmBtn.addEventListener('click', function () { close(true); });
            cancelBtn.addEventListener('click',  function () { close(false); });

            // Close on backdrop click
            backdrop.addEventListener('click', function (e) {
                if (e.target === backdrop) close(false);
            });

            // Trap focus + Escape
            backdrop.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { close(false); return; }
                if (e.key === 'Tab') {
                    const focusable = [cancelBtn, confirmBtn];
                    const idx = focusable.indexOf(document.activeElement);
                    if (e.shiftKey) {
                        focusable[(idx - 1 + focusable.length) % focusable.length].focus();
                    } else {
                        focusable[(idx + 1) % focusable.length].focus();
                    }
                    e.preventDefault();
                }
            });
        });
    }

    function _esc(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    return { show };
})();

/* ═══════════════════════════════════════════════════════════════════════════
   4. DARK MODE TOGGLE (3-state: dark → light → system)
   ═══════════════════════════════════════════════════════════════════════════ */
const FhTheme = (function () {
    const KEY    = 'fh-theme';
    const ORDER  = ['dark', 'light', 'system'];
    const LABELS = { dark: 'Dark', light: 'Light', system: 'System' };

    function resolve(pref) {
        if (pref === 'system') {
            return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
        }
        return pref;
    }

    function get() { return localStorage.getItem(KEY) || 'system'; }

    function apply(pref) {
        document.documentElement.setAttribute('data-theme', resolve(pref));
        const btn = document.getElementById('fhThemeBtn');
        const tip = document.getElementById('fhThemeTip');
        if (btn) {
            btn.classList.toggle('is-system', pref === 'system');
            btn.setAttribute('aria-label', 'Theme: ' + LABELS[pref]);
        }
        if (tip) tip.textContent = LABELS[pref];
    }

    function cycle() {
        const next = ORDER[(ORDER.indexOf(get()) + 1) % ORDER.length];
        localStorage.setItem(KEY, next);
        apply(next);
    }

    function init() {
        apply(get());
        const btn = document.getElementById('fhThemeBtn');
        if (btn) btn.addEventListener('click', cycle);
        window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function () {
            if (get() === 'system') apply('system');
        });
    }

    return { init, cycle, get, apply };
})();

/* ═══════════════════════════════════════════════════════════════════════════
   5. KEYBOARD SHORTCUTS
   ═══════════════════════════════════════════════════════════════════════════ */
const FhKeyboard = (function () {
    let modal = null;
    let gPressed = false;
    let gTimer   = null;

    const SHORTCUTS = [
        {
            section: 'Navigation',
            keys: [
                { keys: ['g', 'h'], desc: 'Go to Home' },
                { keys: ['g', 'e'], desc: 'Go to Explore' },
                { keys: ['g', 'd'], desc: 'Go to Dashboard' },
                { keys: ['g', 'b'], desc: 'Go to Bookmarks' },
            ]
        },
        {
            section: 'Actions',
            keys: [
                { keys: ['/'],   desc: 'Focus search' },
                { keys: ['?'],   desc: 'Show keyboard shortcuts' },
                { keys: ['Esc'], desc: 'Close dialog / modal' },
            ]
        },
        {
            section: 'Theme',
            keys: [
                { keys: ['Shift', 'D'], desc: 'Cycle theme (Dark / Light / System)' },
            ]
        }
    ];

    function buildModal() {
        const backdrop = document.createElement('div');
        backdrop.className = 'fh-kbd-modal-backdrop';
        backdrop.id = 'fhKbdModal';
        backdrop.setAttribute('role', 'dialog');
        backdrop.setAttribute('aria-modal', 'true');
        backdrop.setAttribute('aria-label', 'Keyboard shortcuts');

        let sectionsHtml = '';
        SHORTCUTS.forEach(function (section) {
            sectionsHtml += '<div class="fh-kbd-modal__section">' +
                '<div class="fh-kbd-modal__section-title">' + section.section + '</div>';
            section.keys.forEach(function (row) {
                const keysHtml = row.keys.map(function (k) {
                    return '<kbd class="fh-kbd">' + k + '</kbd>';
                }).join('<span style="color:var(--fh-text-muted);font-size:.7rem">then</span>');
                sectionsHtml += '<div class="fh-kbd-row">' +
                    '<span>' + row.desc + '</span>' +
                    '<span class="fh-kbd-keys">' + keysHtml + '</span>' +
                '</div>';
            });
            sectionsHtml += '</div>';
        });

        backdrop.innerHTML =
            '<div class="fh-kbd-modal">' +
                '<div class="fh-kbd-modal__header">' +
                    '<span class="fh-kbd-modal__title">⌨️ Keyboard Shortcuts</span>' +
                    '<button class="fh-kbd-modal__close" id="fhKbdClose" aria-label="Close">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
                    '</button>' +
                '</div>' +
                sectionsHtml +
            '</div>';

        return backdrop;
    }

    function openModal() {
        if (modal) return;
        modal = buildModal();
        document.body.appendChild(modal);
        modal.querySelector('#fhKbdClose').focus();
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
    }

    function closeModal() {
        if (!modal) return;
        modal.remove();
        modal = null;
    }

    function isTyping() {
        const el = document.activeElement;
        return el && (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA' ||
                      el.tagName === 'SELECT' || el.isContentEditable);
    }

    function navigate(path) {
        FhTopBar.start();
        window.location.href = path;
    }

    function init() {
        document.addEventListener('keydown', function (e) {
            // Always close modal on Escape
            if (e.key === 'Escape') { closeModal(); return; }

            // Don't fire shortcuts when typing in inputs
            if (isTyping()) return;

            // ? — show shortcuts
            if (e.key === '?') { openModal(); return; }

            // Shift+D — cycle theme
            if (e.shiftKey && e.key.toLowerCase() === 'd') {
                FhTheme.cycle();
                return;
            }

            // t — cycle theme
            if (e.key === 't' && !e.ctrlKey && !e.metaKey) {
                FhTheme.cycle();
                FhToast.info('Theme changed', 'Switched to ' + FhTheme.get() + ' mode', 2000);
                return;
            }

            // / — focus search
            if (e.key === '/') {
                e.preventDefault();
                const searchInput = document.querySelector('[data-fh-search], input[type="search"], input[name="q"]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                } else {
                    // Navigate to explore if no search input on page
                    navigate('/explore');
                }
                return;
            }

            // g + key combos
            if (e.key === 'g' && !e.ctrlKey && !e.metaKey) {
                gPressed = true;
                clearTimeout(gTimer);
                gTimer = setTimeout(function () { gPressed = false; }, 1000);
                return;
            }

            if (gPressed) {
                gPressed = false;
                clearTimeout(gTimer);
                const routes = {
                    h: '/',
                    e: '/explore',
                    d: '/dashboard',
                    b: '/bookmarks',
                };
                if (routes[e.key]) {
                    navigate(routes[e.key]);
                }
            }
        });
    }

    return { init, openModal, closeModal };
})();

/* ═══════════════════════════════════════════════════════════════════════════
   6. FORM DELETE CONFIRM — intercept data-fh-confirm links/buttons
   ═══════════════════════════════════════════════════════════════════════════ */
function initFhConfirmLinks() {
    document.addEventListener('click', function (e) {
        const el = e.target.closest('[data-fh-confirm]');
        if (!el) return;
        e.preventDefault();
        e.stopPropagation();

        const title  = el.dataset.fhConfirmTitle   || 'Are you sure?';
        const msg    = el.dataset.fhConfirmMsg      || 'This action cannot be undone.';
        const type   = el.dataset.fhConfirmType     || 'danger';
        const okText = el.dataset.fhConfirmOk       || 'Confirm';

        FhConfirm.show({ title, msg, type, confirmText: okText }).then(function (confirmed) {
            if (!confirmed) return;
            // If it's a form submit button
            const form = el.closest('form');
            if (form) { form.submit(); return; }
            // If it's a link
            if (el.href) { FhTopBar.start(); window.location.href = el.href; }
        });
    });
}

/* ═══════════════════════════════════════════════════════════════════════════
   7. TOP BAR on navigation links
   ═══════════════════════════════════════════════════════════════════════════ */
function initFhTopBarLinks() {
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a[href]');
        if (!link) return;
        const href = link.getAttribute('href');
        // Only internal, non-anchor, non-js links
        if (!href || href.startsWith('#') || href.startsWith('javascript') ||
            href.startsWith('mailto') || href.startsWith('tel') ||
            link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
        FhTopBar.start();
    });

    // Done when page loads
    window.addEventListener('pageshow', function () { FhTopBar.done(); });
}

/* ═══════════════════════════════════════════════════════════════════════════
   BOOT
   ═══════════════════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function () {
    FhTopBar.init();
    FhToast.init();
    FhTheme.init();
    FhKeyboard.init();
    initFhConfirmLinks();
    initFhTopBarLinks();
    FhTopBar.done(); // page already loaded
});

// Expose globally so Blade views can call them
window.FhToast   = FhToast;
window.FhConfirm = FhConfirm;
window.FhTopBar  = FhTopBar;
window.FhTheme   = FhTheme;
