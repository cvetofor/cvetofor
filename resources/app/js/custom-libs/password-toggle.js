;
(function () {
    let passwordBtns = document.querySelectorAll('[data-pass-icon]');
    passwordBtns.forEach((passwordBtn) => {
        passwordBtn.addEventListener('click', togglePassword)
    })

})()

function togglePassword() {
    let inputItem = this.closest('[data-pass-item]').querySelector('[data-pass-input]');
    this.classList.toggle('password-toggle-icon--hide');
    if (this.classList.contains('password-toggle-icon--hide')) {
        inputItem.setAttribute('type', 'text');
    } else {
        inputItem.setAttribute('type', 'password');
    }
}