(function init100vh(){
    function setHeight() {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
    setHeight();
    window.addEventListener('resize', setHeight);
})();
const fadeIn = (data) => {
    data.el.style.opacity = 0;
    data.el.style.display = data.display || 'block';
    data.el.style.transition = `opacity ${data.timeout}ms`;
    setTimeout(() => {
        data.el.style.opacity = data.opacityIn || 1;
    }, 10);
};
const fadeOut = (data) => {
    data.el.style.opacity = 1;
    data.el.style.transition = `opacity ${data.timeout}ms`;
    data.el.style.opacity = 0;
    setTimeout(() => {
        data.el.style.display = 'none';
    }, data.timeout);
};
const slideDown = (data) => {
    data.el.style.height = `${data.el.scrollHeight}px`;
    data.el.style.transition = `height ${data.timeout}ms`;
}
const slideUp = (data) => {
    data.el.style.height = '';
    data.el.style.transition = `height ${data.timeout}ms`;
}
function enableScrolling() {
  document.body.style = "";
  document.querySelector(".header__row").style = ``;
  document.querySelector("html").classList.remove("disable-scrolling");
}
function disableScrolling() {
  const scrollWidth = window.innerWidth - document.documentElement.clientWidth;
  document.body.style = `padding-right: ${scrollWidth}px`;
  document.querySelector(
    ".header__row"
  ).style = `left: calc(50% - ${scrollWidth}px/2);`;
  document.querySelector("html").classList.add("disable-scrolling");
}

class formValidator {
  constructor(parentForm, options) {
    this.parentForm = document.querySelectorAll(parentForm);
    this.options = options;
    this.inputFileClass = this.options.fileUploadData;
    this.customError = this.options.customErrorMessageData;
    this.maskLength = this.options.maskLength ? this.options.maskLength : 18;
    this.passwordLength = this.options.passwordLength
      ? this.options.passwordLength
      : 5;
    this.customEvents = options.on;
    this.scrollToError = options.scrollToError;
    this.init();
  }

  init() {
    this.parentForm.forEach((formSingle) => {
      this.isFieldValid(formSingle);

      let buttons = formSingle.querySelectorAll("[data-form-trigger]");

      buttons.forEach((button) => {
        button.addEventListener("click", () => {
          if (
            button.querySelector("[data-form-button]").hasAttribute("disabled")
          ) {
            this.fakeButtonEvent(formSingle);
            if (this.scrollToError) {
              this.errorScroll(formSingle);
            }
            this.trigger(button, "invalidForm");

            if (document.querySelector("[data-notification-error]")) {
              document
                .querySelector("[data-notification-error]")
                .classList.remove("hidden");
            }
          }
        });
      });

      formSingle.addEventListener("submit", () => {
        if (this.customEvents && this.customEvents.validForm) {
          event.preventDefault();
          this.trigger(formSingle, "validForm");
        }

        this.isFieldValid(formSingle);
        if (formSingle.classList.contains("invalid")) {
          event.preventDefault();
          this.fakeButtonEvent(formSingle);
        }
      });

      formSingle.addEventListener("change", (e) => {
        this.changeFormFieldsEvent(formSingle, e.target);
        this.trigger(formSingle, "changeForm");
      });

      formSingle.addEventListener("keyup", (e) => {
        this.changeFormFieldsEvent(formSingle, e.target);
        this.trigger(formSingle, "changeForm");
      });

      formSingle.addEventListener("input", (e) => {
        this.changeFormFieldsEvent(formSingle, e.target);
        this.trigger(formSingle, "changeForm");
      });

      formSingle.addEventListener("click", (e) =>
        this.deleteInputFileItem(formSingle, e.target)
      );
    });
  }

  update() {
    this.parentForm.forEach((formSingle) => {
      this.isFieldValid(formSingle);
    });
  }

  clear() {
    this.parentForm.forEach((formSingle) => {
      // очищаем поля
      formSingle.reset();

      // очищаем инпут файл
      if (this.inputFileClass) {
        this.inputFileClass.clear();
      }

      // очищаем кастомные селекты
      let customSelect = formSingle.querySelectorAll("[data-custom-select]");
      customSelect.forEach((item) => {
        getSelected(item);
      });

      // удаляем ошибки
      let errorsFields = formSingle.querySelectorAll(".error");
      errorsFields.forEach((field) => {
        this._removeFieidInvalidClass(field);
      });

      this.isFieldValid(formSingle);
    });
  }

  // добавление пользовательских событий
  trigger(el, event) {
    if (this.customEvents && this.customEvents[event]) {
      el.addEventListener(event, this.customEvents[event]);
      var myEvent = new Event(event);
      el.dispatchEvent(myEvent);
    }
  }

  // скролл к ошибке
  errorScroll(formSingle) {
    let error = formSingle.querySelector(".error");
    let parentModal = formSingle.closest("[data-modal]");
    if (parentModal) {
      let inputholder = error.closest(".inputholder");
      let offset =
        inputholder.getClientRects()[0].top +
        parentModal.scrollTop -
        inputholder.clientHeight -
        30;
      parentModal.scroll(0, offset);
    } else {
      let offset =
        error.getBoundingClientRect().top + window.scrollY - this.scrollToError;
      window.scroll(0, offset);
    }
  }

  // проверка формы на валидность
  // formSingle - форма
  isFieldValid(formSingle) {
    let formRequired = formSingle.querySelectorAll(
      "[data-required]:not([data-no-validate])"
    );
    let formEmail = formSingle.querySelectorAll(
      '[type="email"]:not([data-required]):not([data-no-validate])'
    );
    let formPhone = formSingle.querySelectorAll(
      "[data-mask-tel]:not([data-required]):not([data-no-validate])"
    );
    let formExactLength = formSingle.querySelectorAll(
      "[data-length]:not([data-required]):not([data-no-validate])"
    );
    let formCheckInputs = formSingle.querySelectorAll(
      "[data-check-select]:not([data-no-validate])"
    );
    let formPass = formSingle.querySelectorAll(
      '[type="password"]:not([data-no-validate])'
    );
    let noValidate = formSingle.querySelectorAll("[data-no-validate]");
    let formGroup = formSingle.querySelectorAll("[data-form-group]");

    // проверяем все поля по нужным условиям
    if (this.inputFileClass && this.inputFileClass.parentAttr) {
      let formFiles = formSingle.querySelectorAll(
        `.${this.inputFileClass.classInsert}`
      );

      this._validateInputFiles(formFiles);
    }

    formExactLength.forEach((singleLength) => {
      this._validateExactLength(singleLength);
    });

    formPhone.forEach((singlePhone) => {
      this._validatePhone(singlePhone);
    });

    formEmail.forEach((singleEmail) => {
      this._validateEmail(singleEmail);
    });

    formPass.forEach((singlePass) => {
      this._validatePassword(singlePass);
      this._checkPasswordValue(formPass, singlePass);
    });

    noValidate.forEach((item) => {
      this._removeFieidInvalidClass(item);
    });

    this._validateGroup(formGroup);
    this._validateRequired(formRequired);
    this._validateRadios(formCheckInputs);

    // если в форме есть поля с ошибками, то форма не валидна
    if (formSingle.querySelectorAll(".invalid-field").length) {
      formSingle.classList.add("invalid");
    } else {
      formSingle.classList.remove("invalid");
    }

    // проверяем кнопку отправки
    this._toggleButtonDisabled(formSingle);
  }

  // клик по обертке кнопки чтобы показать ошибки, если форма не валидна
  // formSingle - форма
  fakeButtonEvent(formSingle) {
    if (formSingle.classList.contains("invalid")) {
      let invalidFields = formSingle.querySelectorAll(".invalid-field");

      invalidFields.forEach((invalidField) => {
        this._showError(invalidField);
      });
    }
  }

  // проверка полей на валидацию при их изменении
  // formSingle - форма
  // field - проверяемое поле
  changeFormFieldsEvent(formSingle, field) {
    let formElements = formSingle.querySelectorAll(`input, textarea, select`);

    formElements.forEach((single) => {
      if (field === single) {
        this.isFieldValid(formSingle);
        field.classList.remove("error");
        let backError = formSingle.querySelector('[data-error-text="backend"]');
        if (backError) {
          backError.textContent = "";
        }
        if (this.inputFileClass && this.inputFileClass.parentAttr) {
          let inputFileHolder = field.closest(
            `.${this.inputFileClass.classInsert}`
          );
          if (inputFileHolder) {
            inputFileHolder.classList.remove("error");
          }
        }
      }
    });

    if (document.querySelector("[data-notification-error]")) {
      const notificationError = document.querySelector(
        "[data-notification-error]"
      );
      const hasAnyErrors = [...formElements].some((el) =>
        el.classList.contains("error")
      );

      if (hasAnyErrors) {
        notificationError.classList.remove("hidden");
      } else {
        notificationError.classList.add("hidden");
      }
    }
  }

  // проверка полей на валидацию при удалении input file
  // formSingle - форма
  // field - проверяемое поле
  deleteInputFileItem(formSingle, field) {
    if (this.inputFileClass) {
      if (field.hasAttribute(`data-fileupload-delete`)) {
        this.isFieldValid(formSingle);
        formSingle
          .querySelector(`.${this.inputFileClass.classInsert}`)
          .classList.remove("error");
      }
    }
  }

  // добавляем ошибку.
  // field - проверяемое поле
  _showError(field) {
    field.classList.add("error");

    // если нужно отображать текстовые ошибки
    if (this.options.needErrorMessage) {
      let textMessageType = field.getAttribute("data-text-error");
      let textMessage;
      let errorTip;

      // и если нужны кастомные ошибки и при этом текст для этой ошибки существует, то берем его, иначе берем текст по умолчанию
      if (
        textMessageType &&
        this.customError &&
        this.customError[textMessageType]
      ) {
        textMessage = this.customError[textMessageType];
      } else {
        textMessage = this.options.defaultErrorMessage;
      }

      // если уже есть текст ошибки, то перезатираем его
      let getErrorTip = field.parentNode.querySelector(
        "[data-error-text]:not([data-error-text='backend'])"
      );

      if (!getErrorTip) {
        errorTip = `<span class="error-text" data-error-text="">${textMessage}</span>`;
        field.insertAdjacentHTML("afterEnd", errorTip);
      } else {
        getErrorTip.textContent = textMessage;
      }
    }
  }

  // проверяем email на совпадение по маске.
  // field - проверяемое поле
  _validateEmail(field) {
    if (field) {
      let pattern =
        /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,15})$/;
      let value = field.value;

      if (value.search(pattern) !== 0 && value != "") {
        this._addFieidInvalidClass(field);
      } else {
        this._removeFieidInvalidClass(field);
      }
    }
  }

  // проверяем телефон на количество символов.
  // field - проверяемое поле
  _validatePhone(field) {
    if (field) {
      let value = field.value;

      if (value.length > 0 && value.length < this.maskLength) {
        this._addFieidInvalidClass(field);
      } else {
        this._removeFieidInvalidClass(field);
      }
    }
  }

  // проверяем поле на точное количество символов.
  // field - проверяемое поле
  _validateExactLength(field) {
    if (field) {
      let value = field.value;

      if (
        value.length > 0 &&
        value.length != field.getAttribute("data-length")
      ) {
        this._addFieidInvalidClass(field);
      } else {
        this._removeFieidInvalidClass(field);
      }
    }
  }

  // проверяем инпуты для файлов на минимальное количество
  // field - проверяемое поле
  _validateInputFiles(field) {
    if (field) {
      field.forEach((singleField) => {
        let fileItems = singleField.querySelectorAll(`[data-fileupload-input]`);

        if (fileItems.length < this.inputFileClass.options.minFiles) {
          this._addFieidInvalidClass(singleField);
        } else {
          this._removeFieidInvalidClass(singleField);
        }
      });
    }
  }

  // проверяем селект, группу радиокнопок или чекбоксов(ищем выбранные внутри родительского элемента).
  // parentField - родительский элемент
  _validateRadios(parentField) {
    if (parentField) {
      parentField.forEach((singleField) => {
        let checkedInputs = singleField.querySelectorAll("input:checked");

        if (!checkedInputs.length) {
          this._addFieidInvalidClass(singleField);
        } else {
          this._removeFieidInvalidClass(singleField);
        }
      });
    }
  }

  _validateGroup(parentField) {
    if (parentField.length) {
      if (parentField[0].value == "" && parentField[1].value == "") {
        parentField.forEach((item) => {
          this._addFieidInvalidClass(item);
        });
      } else {
        parentField.forEach((item) => {
          this._removeFieidInvalidClass(item);
        });
      }
    }
  }

  // проверяем дефолтный селект, если выбранная опция disabled, то поле не валидно
  // singleField - проверяемое поле
  _validateDefaultSelect(singleField) {
    if (singleField) {
      let selected = singleField.options.selectedIndex;

      if (singleField.options[selected].disabled === true) {
        this._addFieidInvalidClass(singleField);
      } else {
        this._removeFieidInvalidClass(singleField);
      }
    }
  }

  // проверяем пароль на минимальное количество символов.
  // field - проверяемое поле
  _validatePassword(field) {
    if (field && !field.hasAttribute("data-equal")) {
      let value = field.value;

      if (value.length > 0 && value.length < this.passwordLength) {
        this._addFieidInvalidClass(field);
      } else {
        this._removeFieidInvalidClass(field);
      }
    }
  }

  // проверяем пароли на совпадение.
  _checkPasswordValue(allPassFiled, field) {
    if (field && field.hasAttribute("data-equal")) {
      let equalName = field.getAttribute("data-equal");
      allPassFiled.forEach((item) => {
        if (item.hasAttribute(equalName)) {
          if (item.value != field.value) {
            this._addFieidInvalidClass(field);
          } else {
            this._removeFieidInvalidClass(field);
          }
        }
      });
    }
  }

  // проверяем обязательные поля.
  // field - проверяемое поле
  _validateRequired(field) {
    if (field) {
      field.forEach((singleField) => {
        // проверяем ВСЕ обязательные поля на пустоту.
        // если они не пустые, то проверяем email, телефон или дефолтный селект или просто убираем ошибку
        if (singleField.value.trim() === "") {
          this._addFieidInvalidClass(singleField);
        } else {
          if (singleField.type === "email") {
            this._validateEmail(singleField);
          } else if (singleField.hasAttribute("data-mask-tel")) {
            this._validatePhone(singleField);
          } else if (singleField.tagName === "SELECT") {
            this._validateDefaultSelect(singleField);
          } else if (singleField.hasAttribute("data-length")) {
            this._validateExactLength(singleField);
          } else if (singleField.type === "password") {
            this._validatePassword(singleField);
          } else {
            this._removeFieidInvalidClass(singleField);
          }
        }
      });
    }
  }

  // если в форме есть ошибки(класс invalid), то блокируем кнопку
  // formSingle - форма
  _toggleButtonDisabled(formSingle) {
    let formButtons = formSingle.querySelectorAll("[data-form-button]");
    formButtons.forEach((formButton) => {
      if (formSingle.classList.contains("invalid")) {
        formButton.setAttribute("disabled", true);
      } else {
        formButton.removeAttribute("disabled");
      }
    });
  }

  // добавление класса, если поле не валидно
  _addFieidInvalidClass(element) {
    element.classList.add("invalid-field");
  }
  // удаление класса, если поле валидно
  _removeFieidInvalidClass(element) {
    element.classList.remove("invalid-field", "error");
  }
}

function showThanks(form) {
    let formHolder = form.closest(`[data-form]`);
    let formBody = formHolder.querySelector('[data-form-body]');
    let formThanks = formHolder.querySelector('[data-form-thanks]');
    fadeOut({
        el: formBody,
        timeout: 0
    });
    fadeIn({
        el: formThanks,
        display: 'flex',
    });
}
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

document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-tippy]")) {
    const tooltips = document.querySelectorAll("[data-tippy]");

    if (tooltips.length) {
      tooltips.forEach((tooltip) => {
        const addCloseBtn = tooltip.dataset.tippyClose ? true : false;

        tippy(tooltip, {
          content: (reference) => {
            return reference.querySelector("[data-tippy-content]")
              ? reference.querySelector("[data-tippy-content]").innerHTML
              : reference.dataset.tooltipContent;
          },
          allowHTML: true,
          interactive: true,
          zIndex: 3,
          onShow(instance) {
            if (
              addCloseBtn &&
              !instance.popper.querySelector("[data-tippy-close]")
            ) {
              createCloseBtn(instance);
            }

            if (instance.popper.querySelector("[data-tippy-close]")) {
              addCloseBtnEvents(instance);
            }
          },
          onHide(instance) {
            if (instance.popper.querySelector("[data-tippy-close]")) {
              removeCloseBtnEvents(instance);
            }
          },
        });
      });
    }

    function createCloseBtn(instance) {
      const btnClose = document.createElement("button");

      btnClose.classList.add("tippy-close");
      btnClose.setAttribute("data-tippy-close", "");
      instance.popper.querySelector(".tippy-content").appendChild(btnClose);
    }

    function addCloseBtnEvents(instance) {
      instance.popper
        .querySelector("[data-tippy-close]")
        .addEventListener("click", () => {
          instance.hide();
        });
    }

    function removeCloseBtnEvents(instance) {
      instance.popper
        .querySelector("[data-tippy-close]")
        .removeEventListener("click", () => {
          instance.hide();
        });
    }
  }
});

class Counter {
  constructor() {
    this.minButton = document.querySelectorAll('[data-counter="minus"]');
    this.maxButton = document.querySelectorAll('[data-counter="plus"]');
  }
  clickCounter(
    buttons,
    minusCount,
    minusToggle,
    plusCount,
    plusToggle,
    countCrement
  ) {
    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        let counterBox = button.closest("[data-counter-box]");
        let input = counterBox.querySelector('[data-counter-input="input"]');
        let minus = counterBox.querySelector('[data-counter="minus"]');
        let plus = counterBox.querySelector('[data-counter="plus"]');
        let inputMinValue = +input.getAttribute("data-counter-min");
        let inputMaxValue = +input.getAttribute("data-counter-max");

        if (input.value == inputMinValue + minusCount) {
          this.countToggleDisable(minus, minusToggle);
        }
        if (input.value == inputMaxValue - plusCount) {
          this.countToggleDisable(plus, plusToggle);
        }
        input.value = +input.value + countCrement;
        var event = new Event('change', { bubbles: true });
        input.dispatchEvent(event);
      });
    });
  }
  clickAllButtons() {
    this.clickCounter(this.minButton, 1, "add", 0, "remove", -1);
    this.clickCounter(this.maxButton, 0, "remove", 1, "add", 1);
  }
  countToggleDisable(name, status) {
    name.classList[status]("count--disable");
  }
  setDisable(item, state, name) {
    let counterState = item.getAttribute(`data-counter-${state}`);
    let inputValue = item.value;
    if (inputValue == counterState) {
      this.countToggleDisable(
        item
          .closest("[data-counter-box]")
          .querySelector(`[data-counter=${name}]`),
        "add"
      );
    }
  }
  setValue(item, state, name) {
    item.value = item.value.replace(/\D/g, "").replace(/^0+/, "");
    let stateValue = +item.getAttribute(`data-counter-${state}`);
    name = item
      .closest("[data-counter-box]")
      .querySelector(`[data-counter=${name}]`);
    if (name.classList.contains("count--disable")) {
      name.classList.remove("count--disable");
    }
    if (state == "min") {
      if (item.value == "" || item.value <= stateValue) {
        item.value = stateValue;
        if (!this.countToggleDisable(name, "contains")) {
          this.countToggleDisable(name, "add");
        }
      }
    } else if (state == "max") {
      if (item.value >= stateValue) {
        item.value = stateValue;
        if (!this.countToggleDisable(name, "contains")) {
          this.countToggleDisable(name, "add");
        }
      }
    }
  }
}

if (document.querySelector('[data-counter-input="input"]')) {
  let counter = new Counter();
  counter.clickAllButtons();
  let counterInput = document.querySelectorAll('[data-counter-input="input"]');
  counterInput.forEach((input) => {
    counter.setDisable(input, "min", "minus");
    counter.setDisable(input, "max", "plus");

    input.addEventListener("blur", () => {
      if (!input.getAttribute("data-counter-min") == "") {
        counter.setValue(input, "min", "minus");
      }
      if (!input.getAttribute("data-counter-max") == "") {
        counter.setValue(input, "max", "plus");
      }
      input.value = input.value.replace(/\D/g, "").replace(/^0+/, "");

      var event = new Event('change', { bubbles: true });
      input.dispatchEvent(event);
    });
  });
}

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
document.addEventListener("DOMContentLoaded", function () {
  let mapItem = document.querySelector("[data-map]");
  if (mapItem) {
    let mapOverlay = mapItem.closest("[data-map-overlay]");

    ymaps.ready(() => {
      initSimpleMap(mapItem);
    });

    if (mapOverlay) {
      mapOverlay.addEventListener("mouseleave", function () {
        this.classList.add("map--no-touch");
      });

      mapOverlay.addEventListener("click", function () {
        this.classList.remove("map--no-touch");
      });
    }
  }
});

let btnsShowAddressOnMap = Array.from(
  document.querySelectorAll("[data-map-address]")
);

function initSimpleMap(mapItem) {
  let mapCoords = mapItem.getAttribute("data-map-coords").split(",");
  let mapIcon = mapItem.getAttribute("data-map-icon");

  let myMap = new ymaps.Map(mapItem, {
    center: mapCoords,
    zoom: 17,
    controls: [],
  });

  addPointsToMap(myMap, mapIcon);
}

function addPointsToMap(yandexMap, mapIcon) {
  let pointsManager = new ymaps.ObjectManager();
  let coords = 0;

  ymaps.option.presetStorage.add("mypreset", {
    iconLayout: "default#image",
    iconImageHref: mapIcon,
    iconImageSize: [41, 46],
    iconImageOffset: [-20, -46],
  });

  btnsShowAddressOnMap.forEach((btn, i) => {
    let address = btn.dataset.mapAddress;

    if (i === 0) {
      btn.classList.add("active");
    }

    ymaps
      .geocode(address, {
        results: 1,
      })
      .then(function (res) {
        let firstGeoObject = res.geoObjects.get(0);
        coords = firstGeoObject.geometry.getCoordinates();

        if (i === 0) {
          setMapCenter(yandexMap, 15, coords);
        }

        pointsManager.add({
          type: "Feature",
          id: i,
          geometry: {
            type: "Point",
            coordinates: coords,
          },
          options: {
            iconLayout: "default#image",
            iconImageHref: mapIcon,
            iconImageSize: [41, 46],
            iconImageOffset: [-20, -46],
          },
        });
      });

    btn.addEventListener("click", () => {
      if (!btn.classList.contains("active")) {
        document
          .querySelector("[data-map-address].active")
          .classList.remove("active");
        btn.classList.add("active");
      }

      const pointCoordinates =
        pointsManager.objects.getById(i).geometry.coordinates;

      setMapCenter(yandexMap, 15, pointCoordinates);
    });
  });

  pointsManager.objects.events.add("click", function (e) {
    let objectId = e.get("objectId");

    if (!btnsShowAddressOnMap[objectId].classList.contains("active")) {
      btnsShowAddressOnMap[objectId].click();
    }
  });

  yandexMap.geoObjects.add(pointsManager);
}

function setMapCenter(yandexMap, mapZoom, pointCoordinatesArray) {
  yandexMap.setCenter(pointCoordinatesArray, mapZoom, { checkZoomRange: true });
}
