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
