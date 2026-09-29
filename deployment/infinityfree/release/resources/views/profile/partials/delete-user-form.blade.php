<header class="fh-profile-card__heading">
    <span class="fh-profile-card__icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg></span>
    <div><h2 id="delete-account-title">Delete account</h2><p class="fh-profile-card__intro">Permanently remove your FanHub+ account and its associated data.</p></div>
</header>

<p class="fh-profile-danger-copy">Deleting your account cannot be undone. You’ll be signed out, and your account data will be removed.</p>

<button type="button" class="fh-profile-button--danger" x-on:click="$dispatch('open-modal', 'confirm-user-deletion')">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg>
    Delete account
</button>
