document.addEventListener('DOMContentLoaded', function () {
    let tabItem = document.querySelectorAll('[data-tabs-nav]');

    tabItem.forEach((element) => {
        element.addEventListener('click', toggleTabs);
    });


});

function toggleTabs() {
    let tabParent = this.closest('[data-tabs]');
    let currentTabName = this.getAttribute('data-tabs-nav');
    let currentFold = tabParent.querySelector(`[data-tabs-fold="${currentTabName}"]`);
    let prevTab = tabParent.querySelector(`[data-tabs-nav].active`);
    let prevTabName = prevTab.getAttribute('data-tabs-nav');
    let prevFold = tabParent.querySelector(`[data-tabs-fold="${prevTabName}"]`);

    if (!this.classList.contains('active')) {
        this.classList.add('active');

        if(currentFold) {
            currentFold.classList.add('open');
            fadeIn({
                el: currentFold,
                timeout: 300
            });
        }

        prevTab.classList.remove('active');
        if(prevFold) {
            prevFold.classList.remove('open');
            fadeOut({
                el: prevFold,
                timeout: 0
            });
        }
    }
}