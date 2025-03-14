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
