@props([
    'action',
    'method'      => 'DELETE',
    'title'       => 'Are you sure?',
    'msg'         => 'This action cannot be undone.',
    'type'        => 'danger',
    'confirmText' => 'Delete',
    'cancelText'  => 'Cancel',
    'class'       => '',
])

<button
    type="button"
    class="{{ $class }}"
    data-fh-confirm
    data-fh-confirm-title="{{ $title }}"
    data-fh-confirm-msg="{{ $msg }}"
    data-fh-confirm-type="{{ $type }}"
    data-fh-confirm-ok="{{ $confirmText }}"
    data-fh-confirm-action="{{ $action }}"
    data-fh-confirm-method="{{ $method }}"
    {{ $attributes->except(['class', 'action', 'method', 'title']) }}
>
    {{ $slot }}
</button>

{{-- Hidden form that gets submitted on confirm --}}
<form id="fh-confirm-form-{{ md5($action) }}"
      action="{{ $action }}"
      method="POST"
      style="display:none">
    @csrf
    @method($method)
</form>

@once
@push('scripts')
<script>
// Wire fh-confirm buttons that have a data-fh-confirm-action to their hidden forms
document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-fh-confirm][data-fh-confirm-action]');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();

    window.FhConfirm && window.FhConfirm.show({
        title:       btn.dataset.fhConfirmTitle   || 'Are you sure?',
        msg:         btn.dataset.fhConfirmMsg      || '',
        type:        btn.dataset.fhConfirmType     || 'danger',
        confirmText: btn.dataset.fhConfirmOk       || 'Confirm',
    }).then(function (ok) {
        if (!ok) return;
        const formId = 'fh-confirm-form-' + btn.dataset.fhConfirmAction
            .split('').reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0)
            .toString(16).replace('-','');
        // Fallback: find form by action attribute
        const form = document.querySelector('form[action="' + btn.dataset.fhConfirmAction + '"]') ||
                     document.getElementById(formId);
        if (form) {
            window.FhTopBar && window.FhTopBar.start();
            form.submit();
        }
    });
});
</script>
@endpush
@endonce
