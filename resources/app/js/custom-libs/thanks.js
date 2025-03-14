function showThanks(form) {
    let formHolder = form.closest(`[data-form]`);
    let formBody = formHolder.querySelector('[data-form-body]');
    let formThanks = formHolder.querySelector('[data-form-thanks]');
    fadeOut({
        el: formBody,
        timeout: 0
    });
    fadeIn({
        el: formThanks,
        display: 'flex',
    });
}