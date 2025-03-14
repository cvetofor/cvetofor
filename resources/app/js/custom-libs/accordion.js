document.addEventListener('DOMContentLoaded', function () {
    let accordions = document.querySelectorAll('[data-accordion]');
    if(accordions) {
        accordions.forEach(accordion => {
            let accordionToggle = accordion.querySelector('[data-accordion-toggle]');
            accordionToggle.addEventListener('click', () => {
                let isMobile = accordion.getAttribute('data-accordion') === 'mobile';
                if (isMobile) {
                    let windowWidth = +accordion.getAttribute('data-accordion-set') || 991;
                    if (window.innerWidth <= windowWidth) {
                        toggleAccordionItem(accordionToggle);
                    }
                } else {
                    toggleAccordionItem(accordionToggle);
                }
            });
        })
    }
});

function toggleAccordionItem(accordionToggle) {
    let accordionItem = accordionToggle.closest('[data-accordion]');
    let accordionContent = accordionItem.querySelector('[data-accordion-content]');
    let accordionGroup = accordionToggle.closest('[data-accordions-group]');

    if (accordionGroup) {
        let prevItem = accordionGroup.querySelector('[data-accordion-toggle].active');
        if (prevItem && !accordionToggle.classList.contains('active')) {
            let prevAccordionItem = prevItem.closest('[data-accordion]');
            let prevAccordionContent = prevAccordionItem.querySelector('[data-accordion-content]');
            toggleAccordion(prevItem, prevAccordionContent, 'remove');
        }
    }

    if (accordionToggle.classList.contains('active')) {
        toggleAccordion(accordionToggle, accordionContent, 'remove');
    } else {
        toggleAccordion(accordionToggle, accordionContent, 'add');
    }
}

function toggleAccordion(itemToggle, content, status) {
    itemToggle.classList[status]('active');
    if(status === 'add') {
        slideDown({
            el: content,
            timeout: 300
        });
    } else {
        slideUp({
            el: content,
            timeout: 300
        });
    }
}