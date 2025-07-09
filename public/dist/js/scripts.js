document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-map-search-input]")) {
    const wrapper = document.querySelector("[data-map-search]");
    const input = wrapper.querySelector("[data-map-search-input]");
    const addresses = document.querySelectorAll("[data-map-address]");
    const btnReset = wrapper.querySelector("[data-map-search-reset]");

    input.addEventListener("keyup", function () {
      [...addresses].forEach((address) => {
        if (
          address.dataset.mapAddress
            .toLowerCase()
            .indexOf(this.value.toLowerCase()) != -1
        ) {
          address.classList.remove("hidden");
        } else {
          address.classList.add("hidden");
        }
      });
    });

    btnReset.addEventListener("click", function () {
      input.value = "";
      [...addresses].forEach((address) => address.classList.remove("hidden"));
    });
  }
});

let phoneFields = document.querySelectorAll("[data-mask-tel]");

let phoneMask = Inputmask({
  mask: "+7 (999) 999-99-99",
  placeholder: "",
  showMaskOnHover: false,
  showMaskOnFocus: false,
}).mask(phoneFields);

const numberFields = document.querySelectorAll("[data-mask-number]");

numberFields.forEach(function (field) {
  const numberMask = Inputmask({
    mask: "9",
    repeat: field.dataset.maskNumber,
  }).mask(field);
});

const codeFields = document.querySelectorAll("[data-mask-code]");

const codeMask = Inputmask({
  mask: "9 9 9 - 9 9 9",
  placeholder: "_",
}).mask(codeFields);

const datepickers = document.querySelectorAll("[data-datepicker]");

initDatepicker(datepickers);

function initDatepicker(datepicker) {
  flatpickr.localize(flatpickr.l10ns.ru);
  const config = {
    timeZone: "local",
    dateFormat: window['cvetofor'].config.flatpickr.dateFormat !== undefined ? window['cvetofor'].config.flatpickr.dateFormat : "d.m.Y",
    minDate: window['cvetofor'].config.flatpickr.minDate !== undefined ? window['cvetofor'].config.flatpickr.minDate : "today",
    disableMobile: "true",
    static: true,
    prevArrow: `
      <svg width="7" height="10" viewBox="0 0 7 10" fill="" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.22955 9.53033C6.52244 9.23744 6.52244 8.76256 6.22955 8.46967L2.75988 5L6.22955 1.53033C6.52244 1.23744 6.52244 0.762563 6.22955 0.469669C5.93666 0.176776 5.46178 0.176776 5.16889 0.469669L1.16889 4.46967C0.875995 4.76256 0.875995 5.23744 1.16889 5.53033L5.16889 9.53033C5.46178 9.82322 5.93666 9.82322 6.22955 9.53033Z" fill=""/>
      </svg>
    `,
    nextArrow: `
      <svg width="7" height="10" viewBox="0 0 7 10" fill="" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.770451 9.53033C0.477558 9.23744 0.477558 8.76256 0.770451 8.46967L4.24012 5L0.770451 1.53033C0.477558 1.23744 0.477558 0.762563 0.770451 0.469669C1.06334 0.176776 1.53822 0.176776 1.83111 0.469669L5.83111 4.46967C6.124 4.76256 6.124 5.23744 5.83111 5.53033L1.83111 9.53033C1.53822 9.82322 1.06334 9.82322 0.770451 9.53033Z" fill=""/>
      </svg>
    `,
  }
  if (window['cvetofor'].config.flatpickr.maxDate !== undefined) {
    config.maxDate = window['cvetofor'].config.flatpickr.maxDate;
  }
  datepicker.flatpickr(config);
}

(function () {
  // переменная, содержащая тексты ошибок. тексты можно менять и добавлять новые
  let messages = {
    phone: "Вы неверно указали телефон",
    email: "Вы неверно указали email",
    name: "Укажите имя",
    surname: "Укажите фамилию",
    comment: "Вы не ввели текст комментария",
    review: "Вы не ввели текст отзыва",
    password: "Вы не ввели пароль",
    passwordLetter: "Вы не ввели пароль из письма",
    newPassword: "Укажите новый пароль",
    newPasswordRepeat: "Укажите ещё раз новый пароль",
    code: "Вы не ввели код",
    date: "Вы не выбрали дату",
    address: "Укажите верный адрес",
    beneficiaryAccount: "Количество символов должно быть 20",
    correspondentAccount: "Количество символов должно быть 20",
    bik: "Количество символов должно быть 9",
    inn: "Количество символов должно быть 10",
    kpp: "Количество символов должно быть 9",
    passwordLength: "Пароль не может быть меньше 5 символов",
    passwordEqual: "Пароли не совпадают",
    postcard: "Введите текст для открытки",
  };

  let scrollToError = window.innerWidth < 1199 ? 50 : 135;

  let validForm = new formValidator("[data-validate-form]", {
    needErrorMessage: true,
    defaultErrorMessage: "Вы не заполнили поле",
    customErrorMessageData: messages,
    maskLength: 18,
    scrollToError,
  });

  const togglePostcard = document.querySelector("[data-toggle-postcard]");

  if (togglePostcard) {
    checkPostcard(togglePostcard);
    togglePostcard.addEventListener("change", function () {
      checkPostcard(togglePostcard);
    });
  }

  function checkPostcard() {
    const postcard = document.querySelector("[data-postcard]");

    if (togglePostcard.checked) {
      postcard.removeAttribute("data-no-validate");
      postcard.removeAttribute("readonly");
      postcard.classList.remove("inputholder__textarea--readonly");
    } else {
      postcard.setAttribute("data-no-validate", "");
      postcard.setAttribute("readonly", "");
      postcard.classList.add("inputholder__textarea--readonly");
    }
  }

  const toggleFields = document.querySelector("[data-toggle-fields]");

  if (toggleFields) {
    const dataFields = toggleFields.dataset.toggleFields;
    const btnShowFields = toggleFields.querySelector("[data-show-fields]");
    const btnHideFields = toggleFields.querySelector("[data-hide-fields]");
    const fields = document.querySelector(`[data-fields="${dataFields}"]`);
    const infotext = document.querySelector("[data-fields-info]");

    btnShowFields.addEventListener("click", function () {
      const invalidFields = fields.querySelectorAll("[data-no-validate]");

      fields.classList.remove("hidden");
      invalidFields.forEach((field) =>
        field.removeAttribute("data-no-validate")
      );
      btnShowFields.classList.add("active");
      btnHideFields.classList.remove("active");
      infotext.classList.add("hidden");

      validForm.update();
    });

    btnHideFields.addEventListener("click", function () {
      const invalidFields = fields.querySelectorAll(".invalid-field");

      fields.classList.add("hidden");
      invalidFields.forEach((field) =>
        field.setAttribute("data-no-validate", "")
      );
      btnHideFields.classList.add("active");
      btnShowFields.classList.remove("active");
      infotext.classList.remove("hidden");

      validForm.update();
    });

    validForm.update();
  }
})();

document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector("[data-header]");
  const headerMenu = document.querySelector("[data-header-menu]");
  const headerSearch = document.querySelector("[data-header-search]");
  const headerSearchToggler = document.querySelector(
    "[data-toggle-header-search]"
  );
  const btnOpenHeaderMenu = document.querySelector("[data-open-header-menu]");
  const btnCloseHeaderMenu = document.querySelector("[data-close-header-menu]");
  const modalCatalog = document.querySelector(`[data-modal="catalog"]`);

  btnOpenHeaderMenu.addEventListener("click", () => {
    headerMenu.classList.add("active");
    disableScrolling();
  });

  btnCloseHeaderMenu.addEventListener("click", () => {
    headerMenu.classList.remove("active");
    enableScrolling();
  });

  headerSearchToggler.addEventListener("click", () => {
    header.classList.toggle("header--search-active");
    headerSearch.classList.toggle("active");
    headerSearchToggler.classList.toggle("active");
  });

  document.addEventListener("click", function (e) {
    if (
      headerSearch.classList.contains("active") &&
      !e.target.closest("[data-header-search], [data-toggle-header-search]")
    ) {
      header.classList.remove("header--search-active");
      headerSearch.classList.remove("active");
      headerSearchToggler.classList.remove("active");
    }
  });

  if (header) {
    window.addEventListener("scroll", () => {
      if (document.documentElement.scrollTop > 0) {
        if (!header.classList.contains("header--scroll")) {
          header.classList.add("header--scroll");
        }
      } else {
        if (header.classList.contains("header--scroll")) {
          header.classList.remove("header--scroll");
        }
      }
    });
  }

  if (modalCatalog) {
    const categories = [...modalCatalog.querySelectorAll("[data-category]")];

    if (categories.length) {
      const btnsOpenCategory = [
        ...modalCatalog.querySelectorAll("[data-category-open]"),
      ];
      const btnsCloseCategory = [
        ...modalCatalog.querySelectorAll("[data-category-close]"),
      ];

      btnsOpenCategory.forEach(function (btn) {
        btn.addEventListener("click", function () {
          btn.nextElementSibling.classList.add("active");
        });
      });

      btnsCloseCategory.forEach(function (btn) {
        btn.addEventListener("click", function () {
          btn.closest("[data-category].active").classList.remove("active");
        });
      });
    }
  }
});

function showNotification(notification) {
  const notificationEl = document.querySelector(
    `[data-notification='${notification}']`
  );

  notificationEl.classList.remove("hidden");
}

function hideNotification(notification) {
  const notificationEl = document.querySelector(
    `[data-notification='${notification}']`
  );

  notificationEl.classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", function () {
  const deliveryAddress = document.querySelector("[data-delivery-address]");

  if (deliveryAddress) {
    ymaps.ready(() => {
      var suggestView = new ymaps.SuggestView("delivery-address", {
        container: document.querySelector("[data-suggest-dropdown]"),
      });
    });

    deliveryAddress.addEventListener("change", function () {
      deliveryAddress.dataset.deliveryAddress = this.value;
    });
  }
});

function getDeliveryAddress() {
  return document.querySelector("[data-delivery-address]").dataset
    .deliveryAddress;
}

function showPreloader(block) {
  block.classList.add("loading");
}

function hidePreloader(block) {
  block.classList.remove("loading");
}

document.addEventListener("DOMContentLoaded", function () {
  const sliderBanner = new Swiper('[data-swiper="banner"]', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 5000,
    },
    simulateTouch: false,
    watchOverflow: true,
    navigation: {
      nextEl: '[data-swiper="banner-button-next"]',
      prevEl: '[data-swiper="banner-button-prev"]',
    },
    pagination: {
      el: '[data-swiper="banner-pagination"]',
      type: "bullets",
      clickable: true,
    },
  });

  const sliderProducts = new Swiper('[data-swiper="products"]', {
    slidesPerView: "auto",
    spaceBetween: 24,
    loop: true,
    watchOverflow: true,
    navigation: {
      nextEl: '[data-swiper="products-button-next"]',
      prevEl: '[data-swiper="products-button-prev"]',
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 4,
      },
    },
  });

  const sliderProductDetail = new Swiper('[data-swiper="product-detail"]', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    watchOverflow: true,
    navigation: {
      nextEl: '[data-swiper="product-detail-button-next"]',
      prevEl: '[data-swiper="product-detail-button-prev"]',
    },
    pagination: {
      el: '[data-swiper="product-detail-pagination"]',
      type: "bullets",
      clickable: true,
    },
  });
});

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-video-play]")) {
    const btnsPlayVideo = document.querySelectorAll("[data-video-play]");

    btnsPlayVideo.forEach((btn) => {
      btn.addEventListener("click", () => {
        const videoWrap = btn.closest("[data-video-wrap]");
        const video = videoWrap.querySelector("[data-video]");
        const videoPreview = videoWrap.querySelector("[data-video-preview]");

        fadeOut({
          el: btn,
          timeout: 500,
        });

        if (videoPreview) {
          fadeOut({
            el: videoPreview,
            timeout: 500,
          });
        }

        videoWrap.classList.remove("video--overlay");
        video.setAttribute(
          "src",
          `${video.getAttribute("src") + "?autoplay=1"}`
        );
      });
    });
  }
});

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

