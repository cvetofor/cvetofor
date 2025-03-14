let modalTimer;

class Modal {
  constructor() {
    this.overlay = document.querySelector("[data-overlay]");
    this.closeElems = document.querySelectorAll(
      "[data-modal-close], [data-overlay]"
    );
    this.showElems = document.querySelectorAll("[data-modal-open]");
    this.previousModal = null;
    this.validFormModal = new formValidator("[data-validate-form]", {});
  }
  clickShow() {
    this.showElems.forEach((button) => {
      button.addEventListener("click", () => {
        let modal = button.getAttribute("data-modal-open");
        let parentModal = button.closest("[data-modal]");
        if (parentModal) {
          let parentModalName = parentModal.getAttribute("data-modal");
          let parentElem = document.querySelector(
            `[data-modal=${parentModalName}]`
          );
          fadeOut({
            el: parentElem,
            timeout: 500,
          });
          parentElem.classList.remove("modal--vis");
          if (modal === "policy") {
            this.previousModal = parentModalName;
          } else {
            this.previousModal = null;
          }
        }
        this.show(modal);
      });
    });
  }
  clickClose() {
    this.closeElems.forEach((button) => {
      button.addEventListener("click", () => {
        let modal = document.querySelector(".modal--vis");
        if (this.previousModal) {
          this.close(modal.getAttribute("data-modal"), true, false);
          this.show(this.previousModal);
          this.previousModal = null;
        } else {
          this.close(modal.getAttribute("data-modal"));
        }
      });
    });
  }
  backToForm(formHolder) {
    let holder = document.querySelector(`[data-modal=${formHolder}]`);
    let formBody = holder.querySelector(`[data-form-body]`);
    let formThanks = holder.querySelector(`[data-form-thanks]`);
    if (formBody) {
      formBody.style = "";
    }
    if (formThanks) {
      formThanks.style = "";
    }
    if (this.validFormModal) {
      this.validFormModal.clear();
    }
  }
  close(modal, isModalForm = true, closeOverlay = true) {
    if (modal === "delivery-area" || modal === 'invoice-payment') {
      isModalForm = false;
     }

    let thisModal = document.querySelector(`[data-modal=${modal}]`);
    if (modal !== "notification-added-to-cart") {
      if (closeOverlay) {
        fadeOut({
          el: this.overlay,
          timeout: 500,
        });
      }
    }
    fadeOut({
      el: thisModal,
      timeout: 500,
    });
    thisModal.classList.remove("modal--vis");
    setTimeout(() => {
      if (
        modal === "catalog" &&
        document.querySelector(`[data-modal=${modal}] [data-category].active`)
      ) {
        document
          .querySelector(`[data-modal=${modal}] [data-category].active`)
          .classList.remove("active");
      }
    }, 500);
    if (isModalForm) {
      this.backToForm(modal);
    }
    if (modal !== "notification-added-to-cart") {
      enableScrolling();
    }

    let modalScrollEl = thisModal.querySelector("[data-scroll-container]");

    if (modalScrollEl) {
      modalScrollEl.scrollTop = 0;
    }
  }
  show(modal, data) {
    let thisModal = document.querySelector(`[data-modal=${modal}]`);
    let activePP = document.querySelectorAll(".modal--vis");

    if (activePP.length) {
      return false;
    }

    if (data) {
      this.create(thisModal, data);
    }

    if (modal !== "notification-added-to-cart") {
      fadeIn({
        el: this.overlay,
        timeout: 500,
        display: "block",
        opacityIn: 0.5,
      });
    }

    fadeIn({
      el: thisModal,
      timeout: 500,
      display: "block",
    });
    thisModal.classList.add("modal--vis");

    if (modal !== "notification-added-to-cart") {
      disableScrolling();
    }
    return true;
  }
  create(modal, data) {
    let modalList = modal.querySelector("[data-modal-list]");
    let modalItem = modal.querySelector("[data-modal-item]");
    let modalItemClone = modalItem.cloneNode(true);
    modalList.innerHTML = "";
    JSON.parse(data).forEach((dataEl) => {
      modalItemClone
        .querySelector("[data-modal-img]")
        .setAttribute("src", dataEl.image);
      modalItemClone.querySelector("[data-modal-title]").textContent =
        dataEl.title;
      modalItemClone.querySelector("[data-modal-price]").textContent =
        dataEl.price;
      modalList.insertAdjacentHTML("beforeend", modalItemClone.outerHTML);
    });
  }
  // EXAMPLE_ParamsModal() {
  //     let exampleButton = document.querySelector('[data-modal-json]');
  //     if(exampleButton) {
  //         exampleButton.addEventListener('click', () => {
  //             this.show('json', '[{"image": "img/image/product-detail-pic.png","title": "Элемент 1","price": 100000}, {"image": "img/image/product-detail-pic.png","title": "Элемент 2","price": 200000}, {"image": "img/image/product-detail-pic.png","title": "Элемент 3","price": 300000}]');
  //         });
  //     }
  // }
}
let modal = new Modal();
document.addEventListener("DOMContentLoaded", function () {
  modal.clickShow();
  modal.clickClose();
});
