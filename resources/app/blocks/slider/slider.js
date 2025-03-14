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
