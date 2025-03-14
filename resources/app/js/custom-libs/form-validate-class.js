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
