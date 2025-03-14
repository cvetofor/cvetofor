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
