document.addEventListener('DOMContentLoaded', function () {
    let customSelects = document.querySelectorAll('[data-select]');
    customSelects.forEach(select => {
        let button = select.querySelector('[data-select-btn]');
        let selectInputs = select.querySelectorAll('[data-select-input]');

        getSelected(select);

        button.addEventListener('click', () => showSelectList(button));
        document.addEventListener('mouseup', (e) => hideOpenSelect(e, button));

        selectInputs.forEach(input => {
            input.addEventListener('change', () => getSelected(select));
        });
    });
});
// select toggle
function showSelectList(button) {
    let optionList = button.closest('[data-select]').querySelector('[data-select-list]');
    if (button.classList.contains('open')) {
        closeSelect(button, optionList);
    } else {
        openSelect(button, optionList);
    }
}
// select return active items
function getSelected(select) {
    let optionList = select.querySelector('[data-select-list]');
    let optionItems = optionList.querySelectorAll('[data-select-input]');
    let isDefaultText = select.querySelector('[data-select-default]');
    let button = select.querySelector('[data-select-btn]');
    let isClosing = select.getAttribute('data-close-on-select');
    let placeInsert = select.querySelector('[data-select-changing]');
    let choosenArray = [];
    let insertText = '';
    let optionText;
    optionItems.forEach(option => {
        optionText = option.closest('[data-select-option]');
        if (option.checked) {
            optionText.classList.add('active');
            choosenArray.push(optionText.textContent.trim());
        } else {
            optionText.classList.remove('active');
        }
    });

    if (choosenArray.length) {
        insertText = choosenArray.join('; ');
    } else {
        if (isDefaultText) {
            insertText = isDefaultText.getAttribute('data-select-default');
        }
    }

    placeInsert.textContent = insertText;

    if (JSON.parse(isClosing)) {
        closeSelect(button, optionList);
    }
}
// select close on click around
function hideOpenSelect(e, button) {
    if (button.classList.contains('open')) {
        let select = button.closest('[data-select]');
        let optionList = select.querySelector('[data-select-list]');
        let isSelect = e.target == select || select.contains(e.target);
        if (!isSelect) {
            closeSelect(button, optionList);
        }
    }
}
// select close
function closeSelect(button, optionList) {
    button.classList.remove('open');
    fadeOut({
        el: optionList,
        timeout: 500
    });
}
// select open
function openSelect(button, optionList) {
    button.classList.add('open');
    fadeIn({
        el: optionList,
        timeout: 500
    });
}

