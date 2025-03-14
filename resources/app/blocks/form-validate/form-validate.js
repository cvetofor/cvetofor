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
