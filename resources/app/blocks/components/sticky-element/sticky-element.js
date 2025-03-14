document.addEventListener("DOMContentLoaded", function () {
  let stickyBlocks = document.querySelectorAll("[data-sticky]");
  stickyBlocks.forEach((stickyBlock) => {
    let stickyElement = stickyBlock.querySelector("[data-sticky-element]");

    stickyElementScroll(stickyBlock, stickyElement);

    window.addEventListener("scroll", () => {
      if (isElementInViewport(stickyBlock)) {
        stickyElementScroll(stickyBlock, stickyElement);
      }
    });

    window.addEventListener("resize", () => clearStickyStyle(stickyElement));
  });
});

// прокрутка элемента
function stickyElementScroll(stickyBlock, stickyElement) {
  let windowWidth = stickyElement.getAttribute("data-sticky-unset") || 991;

  if (window.innerWidth > windowWidth) {
    if (stickyElement.clientHeight < stickyBlock.clientHeight) {
      let stickyElementWidth = stickyElement.offsetWidth;
      let topScrollSpace =
        +stickyElement.getAttribute("data-sticky-element") || 0;
      let stickyBlockOffset =
        stickyBlock.getBoundingClientRect().y + window.pageYOffset;
      let stickyBlockHeight =
        stickyBlock.clientHeight - stickyElement.clientHeight;
      let scrollStart = stickyBlockOffset - topScrollSpace;

      if (
        window.scrollY >= scrollStart &&
        window.scrollY < scrollStart + stickyBlockHeight
      ) {
        stickyElement.classList.add("sticky__element--fix");
        stickyElement.classList.remove("sticky__element--absolute");
        stickyElement.style.top = `${topScrollSpace}px`;
        stickyElement.style.width = `${stickyElementWidth}px`;
      } else if (window.scrollY < stickyBlockOffset) {
        stickyElement.classList.remove(
          "sticky__element--fix",
          "sticky__element--absolute"
        );
        stickyElement.style.top = "";
        stickyElement.style.width = "";
      } else {
        stickyElement.classList.remove("sticky__element--fix");
        stickyElement.classList.add("sticky__element--absolute");
        stickyElement.style.top = "";
        stickyElement.style.width = `${stickyElementWidth}px`;
      }
    }
  }
}

// очищение стилей и классов
function clearStickyStyle(stickyElement) {
  let windowWidth = +stickyElement.getAttribute("data-sticky-unset") || 991;
  if (window.innerWidth <= windowWidth) {
    stickyElement.classList.remove(
      "sticky__element--fix",
      "sticky__element--absolute"
    );
    stickyElement.style.top = "";
    stickyElement.style.width = "";
  }
}

// проверка, находится ли элемент в зоне видимости
function isElementInViewport(el) {
  let top = el.offsetTop;
  let left = el.offsetLeft;
  let width = el.offsetWidth;
  let height = el.offsetHeight;

  while (el.offsetParent) {
    el = el.offsetParent;
    top += el.offsetTop;
    left += el.offsetLeft;
  }

  return (
    top < window.pageYOffset + window.innerHeight &&
    left < window.pageXOffset + window.innerWidth &&
    top + height > window.pageYOffset &&
    left + width > window.pageXOffset
  );
}
