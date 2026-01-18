
function request(url, method = "GET", data) {
  return fetch(url, {
    method: method,
    redirect: "follow",
    body: JSON.stringify(data),
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'url': url,
      "X-CSRF-Token": document.querySelector('[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest'
    },
  }).then(response => {

    const contentType = response.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {

      if (response.ok) {
        return response.json().then(response => ({response}));
      }
      return response.json().then(error => ({error}));

    } else {
      if (response.ok) {
        return response.text().then(response => ({response}));
      }
      return response.text().then(error => ({error}));
    }


  })
}

function delay(callback, ms) {
  var timer = 0;
  return function () {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}


// Выпадающий список в шапке, в форме поиска
document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-header-search-input]")) {
    const wrapper = document.querySelector("[data-header-search]");
    const input = wrapper.querySelector("[data-header-search-input]");
    const tip = wrapper.querySelector("[data-header-search-tip]");

    input.addEventListener("keyup", delay(async function () {
      const inputVal = input.value.length;



      if (inputVal >= 2) {

        const {response, error} = await request(window['cvetofor'].config.routes.search.get(), "POST", {q: input.value});

        if (response) {

          let html = Object.values(response.data).map(e => {
            return `
            <li class="dropdown__list-item">
              <a class="dropdown__list-link" href="${e.href}">
                  <span class="dropdown__list-link__title">
                    ${e.title}
                  </span>
                  <span class="dropdown__list-link__price">${e.price}
                      р.</span>
              </a>
            </li>`
          });
          tip.querySelector('.dropdown__list').innerHTML = html.join('');
        }

        slideDown({
          el: tip,
          timeout: 300,
        });
        tip.style.width = '100 %;';

      } else {
        slideUp({
          el: tip,
          timeout: 300,
        });
      }
    }, 300));
  }
});

// Выпадающий список в модалке выбора города, в форме поиска
document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-modal-city-input]")) {
    const wrapper = document.querySelector("[data-modal-city-search]");
    const input = wrapper.querySelector("[data-modal-city-input]");
    const tip = wrapper.querySelector("[data-modal-city-tip]");


    const clickItem = async function (element) {

      const url = window['cvetofor'].config.routes.cities.set(element.target.dataset.cityId);
      const {response, error} = await request(url, 'POST');

      if (response) {
        modal.close("city");
        document.querySelector('.header__city-text').textContent = response.name;
        window.location.reload();
      }
    };

    const el = document.querySelector("[data-modal-cities-wrappet]");

    el.querySelectorAll('[data-city-id]').forEach(function (item) {

      item.addEventListener('click', clickItem);

    });


    input.addEventListener("keyup", delay(async function () {
      const inputVal = input.value.length;



      let url = window['cvetofor'].config.routes.cities.filter(input.value);

      if (inputVal == 0) {
        url = window['cvetofor'].config.routes.cities.all(input.value)
      }

      if (inputVal >= 2 || inputVal == 0) {
        slideDown({
          el: tip,
          timeout: 300,
        });


        const el = document.querySelector("[data-modal-cities-wrappet]");
        el.innerHTML = "";

        const {response, error} = await request(url, "POST");


        if (response.data) {
          if (typeof (response.data) === 'object' && response.data.city) {
            el.innerHTML += `<li class="modal__cities-list__item" data-city-id="${response.data.id}">${response.data.city}</li>`;
          } else if (Array.isArray(response.data)) {
            response.data.forEach(e => {
              el.innerHTML += `<li class="modal__cities-list__item" data-city-id="${e.id}">${e.city}</li>`;
            })
          }

          el.querySelectorAll('[data-city-id]').forEach(function (item) {
            item.addEventListener('click', clickItem);
          });

          slideUp({
            el: tip,
            timeout: 300,
          });
        }

      } else {
        slideUp({
          el: tip,
          timeout: 300,
        });
      }


    }, 500));
  }
});

// Добавление и удаление рекомендуемого товара в корзине
document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-cart-additional-item]")) {
    const items = document.querySelectorAll("[data-cart-additional-item]");

    items.forEach(function (item) {
      const btnAddItem = item.querySelector("[data-cart-additional-item-add]");
      const btnRemoveItem = item.querySelector(
        "[data-cart-additional-item-remove]"
      );
      const iconCheck = item.querySelector("[data-cart-additional-item-check]");

      btnAddItem.addEventListener("click", function () {
        btnAddItem.classList.add("hidden");
        btnRemoveItem.classList.remove("hidden");
        iconCheck.classList.remove("hidden");
      });

      btnRemoveItem.addEventListener("click", function () {
        btnRemoveItem.classList.add("hidden");
        btnAddItem.classList.remove("hidden");
        iconCheck.classList.add("hidden");
      });
    });
  }
});


const createElementFromHTML = function (htmlString) {
  var div = document.createElement('div');
  div.innerHTML = htmlString.trim();

  // Change this to div.childNodes to support multiple top-level nodes.
  return div.firstChild;
}

const LoadMore = function (child = null) {

  const dom = child ? child : document;

  // Кнопка загрузить еще
  if (dom.querySelector("[data-category-items]")) {
    const items = dom.querySelectorAll("[data-category-items]");

    items.forEach(function (item) {
      const btnMore = item.querySelector("[data-load-more]");

      if (btnMore) {

        btnMore.addEventListener("click", async function (e) {
          e.preventDefault();

          btnMore.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
          btnMore.setAttribute('disabled', 'disabled');
          const {response, error} = await request(btnMore.getAttribute('href'));

          if (response) {
            setTimeout(() => {
              btnMore.remove();
              const html = createElementFromHTML(response.data[item.dataset.categoryItems]);

              item.innerHTML += html.innerHTML;
              LoadMore(item.parentNode);
              PutToCart();
            }, 300);


          }

        });
      }

    });
  }

}

// Кнопка добавить в корзине
const PutToCart = function () {
  const cartButtons = document.querySelectorAll('[data-put-cart-sku],[data-cart-additional-item-add]');

  if (cartButtons) {
    cartButtons.forEach(function (button) {
      button.addEventListener('click', async function (e) {

        let sku = '';
        let link = window['cvetofor'].config.routes.cart.put;

        if (button.getAttribute('data-cart-additional-item-add')) {
          sku = button.getAttribute('data-id');
          link = window['cvetofor'].config.routes.cart.putAdditional;
        } else {
          sku = button.getAttribute('data-put-cart-sku');
        }


        shareLastSku = sku;

        const {response, error} = await request(link(sku), "PUT");

        if (response) {
          if (button.getAttribute('data-cart-additional-item-add')) {
            window.location.reload();
          }

          try {
            let image = button.closest('.product').querySelector('.product__image').getAttribute('src');
            document.querySelector('[data-modal="notification-added-to-cart"] .modal__image').setAttribute('src', image);

          } catch (error) {}

          modal.show("notification-added-to-cart");
          setTimeout(function () {
            modal.close("notification-added-to-cart");
          }, 2000);

          setCounter(response.count)
        }
        else if (error) {
          if (error.modal) {
            modal.show(error.modal);
          }
          else {
            alert(error.message);
          }
        }

      });
    });
  }
}

// Загрузить ещё
document.addEventListener("DOMContentLoaded", () => LoadMore());
document.addEventListener("DOMContentLoaded", () => PutToCart());

// Таймер для модалок с подтверждением кодом
function startModalTimer(modal) {
  const modalEl = document.querySelector(`[data-modal='${modal}']`);
  const repeatCode = modalEl.querySelector("[data-repeat-code]");
  const btnRepeatCode = modalEl.querySelector("[data-repeat-code-button]");

  let count = parseInt(
    repeatCode.querySelector("[data-repeat-code-timer]").dataset.repeatCodeTimer
  );

  function tick() {
    if (count === 0) {
      clearInterval(timer);
      repeatCode.classList.add("hidden");
      btnRepeatCode.classList.remove("hidden");
      count = repeatCode.querySelector("[data-repeat-code-timer]").dataset
        .repeatCodeTimer;
    }

    repeatCode.querySelector(
      "[data-repeat-code-timer]"
    ).innerHTML = `${count--}`;
  }

  timer = setInterval(() => {
    tick();
  }, 1000);

  tick();

  btnRepeatCode.addEventListener("click", function () {
    btnRepeatCode.classList.add("hidden");
    repeatCode.classList.remove("hidden");

    timer = setInterval(() => {
      tick();
    }, 1000);
  });
}

function clearModalTimer() {
  clearInterval(timer);
}


const ChangeModalProductPrice = function (elements) {
  let total = basePrice;


  elements.forEach(function (input) {
    const price = input.dataset.price;
    const count = input.value;

    total += Number.parseFloat(price) * Number.parseFloat(count);

  });
  total = Math.round(total);

  document.querySelector('.modal__total-price').innerHTML = total + 'р.';
  return total;
}


let productData = {
  composition: {},
  price: 0.0,
};

const ChangeModalProductPriceMono = function (elements) {
  let total = basePrice;


  elements.forEach(function (input) {
    let prices = Object.values(JSON.parse(input.dataset.prices)).sort((a, b) => Number.parseInt(a.quantity_from) > Number.parseInt(b.quantity_from));
    const count = input.value;

    let priceObj = prices.filter(e => {
      return count >= Number.parseInt(e.quantity_from);
    });
    priceObj = priceObj.slice(-1);

    const price = priceObj[0].price;
    total += Number.parseFloat(price) * Number.parseFloat(count);


    productData.composition[input.getAttribute('name')] = {
      count: input.value,
      id: priceObj[0].id,
      color: input.getAttribute('data-color') ? input.getAttribute('data-color') : null,
      hiddenCount: productCounter[number],
    };
  });
  total = Math.round(total);

  //   document.querySelector('.modal__total-price--new').innerHTML = total + 'р.';
  productData.price = total;

  return total;
}

const ChangeProductCounts = function (elements) {
  document.querySelector('.product-detail__price').innerHTML = ChangeModalProductPriceMono(elements) + 'р.';
  elements.forEach(function (input) {
    let name = input.getAttribute('name');
    document.querySelector(['[data-count="' + name + '"]']).innerHTML = input.value + ' шт.';
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const inputsMono = document.querySelectorAll('[data-mono="false"] * [data-counter-input]');

  const buttonIsEnabled = !document.querySelector('.add-to-cart-button.disabled');

  if (inputsMono.length > 0 && buttonIsEnabled) {
    ChangeProductCounts(inputsMono);

    inputsMono.forEach(function (input) {
      input.addEventListener('change', function () {
        ChangeModalProductPrice(inputsMono);
        ChangeProductCounts(inputsMono);
      });
      input.addEventListener('input', function () {
        ChangeModalProductPrice(inputsMono);
        ChangeProductCounts(inputsMono);
      });
    });
  }


  const inputs = document.querySelectorAll('[data-mono="true"] * [data-counter-input]');
  if (inputs.length > 0 && buttonIsEnabled) {
    ChangeProductCounts(inputs);
    inputs.forEach(function (input) {
      input.addEventListener('change', function () {
        ChangeModalProductPrice(inputs);
        ChangeModalProductPriceMono(inputs);
        ChangeProductCounts(inputs);
      });
      input.addEventListener('input', function () {
        ChangeModalProductPrice(inputs);
        ChangeModalProductPriceMono(inputs);
        ChangeProductCounts(inputs);
      });
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {

  const addToCartButton = document.querySelector('.add-to-cart-button');
  if (addToCartButton) {
    addToCartButton.addEventListener('click', async function (e) {
      e.target.setAttribute('disabled', 'disabled');
      let sku = e.target.getAttribute('data-sku');
      shareLastSku = sku;

      const {response, error} = await request(window['cvetofor'].config.routes.cart.put(sku), "PUT", productData.price > 0 ? productData : null);

      if (response) {
        try {
          let image = document.querySelector('.product-detail__image').getAttribute('src');
          document.querySelector('[data-modal="notification-added-to-cart"] .modal__image').setAttribute('src', image);

        } catch (error) {}

        modal.show("notification-added-to-cart");

        setTimeout(function () {
          modal.close("notification-added-to-cart");
        }, 2000);

        setCounter(response.count)
      }
      else {
        if (error.modal) {
          modal.show(error.modal);
        }
        else {
          alert(error.message);
        }
      }

      e.target.removeAttribute('disabled');
    });

  }
});


document.addEventListener("DOMContentLoaded", function () {


  const modals = document.querySelectorAll('[data-ajax="true"] form');

  modals.forEach(element => element.addEventListener('submit', async function (e) {
    e.preventDefault();
    const target = e.target;

    const btn = target.querySelector("button");

    btn.insertAdjacentHTML('beforeend', '<i class="fa fa-spinner fa-spin"></i>');
    btn.setAttribute('disabled', 'disabled');
    let erElement = target.querySelector('.error-text');

    if (erElement) erElement.remove();


    var data = new FormData(e.target);

    let url = e.target.getAttribute('action');

    const {response, error} = await request(url, 'POST', Object.fromEntries(data));


    if (response || !error) {
      window.location.reload();
    } else {
      let message = error.message;

      if (message == 'CSRF token mismatch.') {
        message = "Сессия истекла, перезагрузите страницу";
      }

      target.querySelector('.form__inputholder').insertAdjacentHTML('beforeend', '<span class="error-text" style="display: block" data-error-text="">' + message + '</span>');
    }
    try {
      btn.removeAttribute('disabled');
      btn.querySelector('i').remove();
    } catch (error) {

    }
  }))


  document.querySelector('[data-modal="password-recovery"] form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const target = e.target;

    const btn = target.querySelector("button");

    btn.insertAdjacentHTML('beforeend', '<i class="fa fa-spinner fa-spin"></i>');
    btn.setAttribute('disabled', 'disabled');

    let erElement = target.querySelector('.error-text');

    if (erElement) erElement.remove();


    var data = new FormData(e.target);

    let url = e.target.getAttribute('action');

    const {response, error} = await request(url, 'POST', Object.fromEntries(data));


    if (response || !error) {
      target.querySelector('.form__inputholder').insertAdjacentHTML('beforeend', '<span style="display: block; color:green;" data-error-text="">' + 'Новый пароль отправляем вам в СМС сообщении.' + '</span>');
    } else {
      let message = error.message;

      if (message == 'CSRF token mismatch.') {
        message = "Сессия истекла, перезагрузите страницу";
      }

      target.querySelector('.form__inputholder').insertAdjacentHTML('beforeend', '<span class="error-text" style="display: block" data-error-text="">' + message + '</span>');
    }

    try {
      btn.removeAttribute('disabled');
      btn.querySelector('i').remove();
    } catch (error) {

    }

  })

});


function setCounter(count) {

  let cartCounters = document.querySelectorAll('.header__control-value, .header__mobcontrol--cart > .header__mobcontrol-value');
  cartCounters.forEach(e => {
    e.innerHTML = count;
  });
}

/**
 * Добавляется в корзину, после очищения корзины
 */
let shareLastSku = '';

document.addEventListener("DOMContentLoaded", function () {



  let modalErrorRegion = document.querySelector('[data-modal="cart-region"]');

  if (modalErrorRegion) {
    try {
      modalErrorRegion.querySelector('[data-clear-cart]').addEventListener('click', async function (e) {

        const {response, error} = await request(window['cvetofor'].config.routes.cart.clear(''), "PUT");

        if (response) {
          const {response, error} = await request(window['cvetofor'].config.routes.cart.put(shareLastSku), "PUT");

          if (response) {

            modal.close('cart-region');

            let image = false;
            try {
              image = button.closest('.product').querySelector('.product__image').getAttribute('src');
              document.querySelector('[data-modal="notification-added-to-cart"] .modal__image').setAttribute('src', image);

            } catch (error) {}

            modal.show("notification-added-to-cart");
            setTimeout(function () {
              modal.close("notification-added-to-cart");
            }, 2000);

            setCounter(response.count);

          }
        }
      });
    } catch (error) {

    }
  }


  const cartItems = document.querySelectorAll('[data-minus-cart-item],[data-plus-cart-item],[data-remove-cart-item],[data-cart-additional-item-remove]');

  const minus = window['cvetofor'].config.routes.cart.minus;
  const plus = window['cvetofor'].config.routes.cart.plus;
  const remove = window['cvetofor'].config.routes.cart.remove;

  if (cartItems) {
    cartItems.forEach((item) => {
      item.addEventListener('click', async function (e) {
        e.target.setAttribute('disabled', 'disabled');

        if (item.getAttribute('data-plus-cart-item')) {
          let {response, error} = await request(plus(item.dataset.plusCartItem), "PUT");
          if (response) {

            window.location.reload();

            setCounter(response.count);
          }
        } else {

          if (item.getAttribute('data-minus-cart-item')) {
            let {response, error} = await request(minus(item.dataset.minusCartItem), "PUT");
            if (response) {

              window.location.reload();

              setCounter(response.count);
            }
          } else {
            let sku = '';

            if (item.getAttribute('data-cart-additional-item-remove')) {
              sku = item.getAttribute('data-id');
            } else {
              sku = item.dataset.removeCartItem;
            }

            let {response, error} = await request(remove(sku), "PUT");
            if (response) {

              window.location.reload();

              setCounter(response.count);
            }
          }
        }



        e.target.removeAttribute('disabled');
      });
    })
  }
});




const reInitSelect = function () {
  let customSelects = document.querySelectorAll('[data-select]');
  customSelects.forEach(select => {
    let button = select.querySelector('[data-select-btn]');
    let selectInputs = select.querySelectorAll('[data-select-input]');

    getSelected(select);
    selectInputs.forEach(input => {
      input.addEventListener('change', () => getSelected(select));
    });
  });
}


const observer = function (e) {
  // Ожидается, что e.target.value имеет формат "DD.MM.YYYY"
  const inputValue = e.target.value;
  if (!inputValue) {
    console.error("Input value is empty.");
    return;
  }

  const parts = inputValue.split('.');
  if (parts.length !== 3) {
    console.error("Invalid date format. Expected DD.MM.YYYY, got:", inputValue);
    return;
  }

  const [day, month, year] = parts.map(Number);
  const inputDate = new Date(year, month - 1, day);
  if (isNaN(inputDate.getTime())) {
    console.error("Parsed date is invalid:", inputDate);
    return;
  }

  // Получаем значение minDateTimeStamp из конфига.
  // Если его нет или оно невалидное, используем текущую дату.
  let minDateTimestamp = window['cvetofor']?.config?.flatpickr?.minDateTimeStamp;
  if (!minDateTimestamp || isNaN(Number(minDateTimestamp))) {
    console.warn("Invalid or missing minDateTimeStamp in config, using current date instead.");
    minDateTimestamp = Date.now();
  } else {
    minDateTimestamp = Number(minDateTimestamp);
    // Если timestamp в секундах, а не в миллисекундах
    if (minDateTimestamp < 10000000000) {
      minDateTimestamp *= 1000;
    }
  }

  const currentDate = new Date(minDateTimestamp);
  if (isNaN(currentDate.getTime())) {
    console.error("Invalid current date from config:", currentDate);
    return;
  }

  // Определяем день недели по inputDate
  const dayWeek = [
    'sunday',
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
  ][inputDate.getDay()];
  const year1 = inputDate.getFullYear();           // 2025
  const month1 = String(inputDate.getMonth() + 1).padStart(2, '0'); // месяцы 0-11
  const day1 = String(inputDate.getDate()).padStart(2, '0');        // день месяца

  const formattedDate = `${year1}-${month1}-${day1}`;




  // Сбрасываем время до полуночи для корректного сравнения
  inputDate.setHours(0, 0, 0, 0);
  currentDate.setHours(0, 0, 0, 0);
  const isToday = inputDate.getTime() === currentDate.getTime();
  // Выбираем массив времени в зависимости от того, является ли выбранная дата сегодняшней
  const times= window['cvetofor'].config.flatpickr.dates[formattedDate]?
    window['cvetofor'].config.flatpickr.dates[formattedDate]:
    (isToday
    ? window['cvetofor'].config.flatpickr.todayTimes
    : window['cvetofor'].config.flatpickr.times[dayWeek]);

  console.log(times);
  console.log(window['cvetofor'].config.flatpickr.dates);

  if (!times) {
    console.error("No times available for day:", dayWeek);
    return;
  }

  const dropElement = document.querySelector('.select__drop');
  if (!dropElement) {
    console.error("Element with class .select__drop not found");
    return;
  }

  dropElement.innerHTML = '';
  Object.values(times).forEach((time, i) => {
    // Предполагается, что time — массив вида [start, end]
    if (time[0] && time[1]) {
      dropElement.innerHTML += `
        <label class="select__item" data-select-option="">
          <input class="select__input" ${i === 0 ? 'checked="checked"' : ''}
                 value="${time[0]}${time[1] ? ' - ' + time[1] : ''}"
                 name="delivery_time" type="radio" data-select-input="" />
          <span>${time[0]}${time[1] ? ' - ' + time[1] : ''}</span>
        </label>`;
    }
  });

  reInitSelect();
};


const addressInput = document.querySelector('[name="address"]');
if (addressInput) {
  addressInput.addEventListener('blur', async (e) => {
    // получим координаты
    await ymaps
      .geocode(e.target.value, {
        results: 1,
      })
      .then(
        function (res) {
          let pointA = res.geoObjects.get(0);
          let points = pointA.geometry.getCoordinates();
          calcDelivery(points);
        },
      );
  });
}

const dontKnowAddressButton = document.querySelector('[data-dont-know-address="true"]');
if (dontKnowAddressButton) {
  dontKnowAddressButton.addEventListener('click', async (e) => {
    calcDelivery({});
  })
}

const knowAddressButton = document.querySelector('[data-know-address="true"]');
if (knowAddressButton) {
  knowAddressButton.addEventListener('click', async (e) => {
    let address = getDeliveryAddress() === 'data-delivery-address' ? document.querySelector('[name="address"]').value : getDeliveryAddress();

    await ymaps
      .geocode(address, {
        results: 1,
      })
      .then(
        function (res) {
          let pointA = res.geoObjects.get(0);
          let points = pointA.geometry.getCoordinates();
          calcDelivery(points,true);
        },
      );
  })
}

async function calcDelivery(points, isKnowAdress) {
  const form = document.querySelector('[data-form="order-checkout"] form');


  try {
    showPreloader(form);
    const data = { coordinates: points, }
    if (isKnowAdress) {
      data['isKnowAdress'] = true
    }

    const { response, error } = await request(window['cvetofor'].config.routes.deliveryRadius.post(), "POST", data);

    if (error && error.modal) {
      if (document.querySelector('[ data-modal="' + error.modal + '"] .modal__text p')) {
        document.querySelector('[ data-modal="' + error.modal + '"] .modal__text p').innerHTML = error.message;
      }
      modal.show(error.modal);



    } else {
      document.querySelector('.cart__summary-total').setAttribute('data-total', response.totalPrice);
      let totalt = new Intl.NumberFormat("ru-RU").format(response.totalPrice)
      document.querySelector('.cart__summary-total').innerHTML = 'Итого: ' + totalt + ' р.';


      let delivery = new Intl.NumberFormat("ru-RU").format(response.totalDeliveryPrice)
      document.querySelector('[data-delivery-price="true"]').innerHTML = delivery + ' р.';

      console.log(delivery);

    }


  } catch (e) {
    console.error(e);
  } finally {
    hidePreloader(form);
  }
}

const Order = async function () {
  const form = document.querySelector('[data-form="order-checkout"] form');
  let dataData = new FormData(document.querySelector('[data-form="order-checkout"] form'));


  // Проверим что выбрана платежная система по счёту
  if (document.querySelector('[name="payment_id"]:checked').hasAttribute('data-account')) {
    let legalAccount = toJson(document.querySelector('[data-modal="invoice-payment"] form'));

    if (
      !legalAccount.recipient ||
      !legalAccount.recipient_account ||
      !legalAccount.bik ||
      !legalAccount.bank ||
      !legalAccount.correspondent_account ||
      !legalAccount.inn ||
      !legalAccount.kpp
    ) {
      modal.show('invoice-payment');
      return false;
    }

    dataData.append('legal_account', JSON.stringify(legalAccount));
  }


  showPreloader(form);



  if (document.querySelector('[name="address"]').offsetParent !== null) {
    try {
      let address = getDeliveryAddress() === 'data-delivery-address' ? document.querySelector('[name="address"]').value : getDeliveryAddress();

      // получим координаты
      await ymaps
        .geocode(address, {
          results: 1,
        })
        .then(
          function (res) {
            let pointA = res.geoObjects.get(0);
            let points = pointA.geometry.getCoordinates();
            dataData.append('coordinates', points);
            calcDelivery(points);
          },
        );
      dataData.append('address', document.querySelector('#delivery-address').value);
    } catch (error) {

    }
  }

  let body = {};
  for (var [key, value] of dataData.entries()) {
    body[key] = value;
  }
  const {response, error} = await request(form.getAttribute('action'), form.getAttribute('method'), body)

  if (response) {
    if (response.redirect) {
      window.location = response.redirect;
    }
  } else if (error) {
    if (error.modal) {
      if (document.querySelector('[ data-modal="' + error.modal + '"] .modal__text p')) {
        document.querySelector('[ data-modal="' + error.modal + '"] .modal__text p').innerHTML = error.message;
      }
      modal.show(error.modal);
    }
    if (error.errors) {
      Object.keys(error.errors).forEach(e => {
        if (document.querySelector('[name="' + e + '"]')) {
          document.querySelector('[name="' + e + '"]').classList.add('invalid-field');
          document.querySelector('[name="' + e + '"]').classList.add('error');
        }
        else {
          document.querySelector('[data-name="' + e + '"]').scrollIntoView({block: "center"});
          document.querySelector('[data-name="' + e + '"]').style = 'border-color: #ca4592;';

          setTimeout(() => {
            document.querySelector('[data-name="' + e + '"]').style = '';
          }, 3000);
        }
      })
    }
    else if (error.message && !error.modal) {
      alert(error.message);
    }
  }

  hidePreloader(form);
}

// order
document.addEventListener('DOMContentLoaded', function () {

  if (datepickers[0]) {
    let picker = datepickers[0];
    picker.addEventListener('change', observer);
  }


  const form = document.querySelector('[data-form="order-checkout"] form');


  if (form) {

    const postcard = document.querySelector('#postcard[data-price]');

    if (postcard) {
      let postcard_price = Number.parseFloat(postcard.getAttribute('data-price') ? postcard.getAttribute('data-price') : 0);

      if (postcard_price > 0) {
        postcard.addEventListener('change', function (e) {

          let total = Number.parseFloat(document.querySelector('.cart__summary-total').getAttribute('data-total')) + postcard_price;

          let t = 0.0;
          if (e.target.checked) {
            t = new Intl.NumberFormat("ru-RU").format(total)
          }
          else {
            t = new Intl.NumberFormat("ru-RU").format(Number.parseFloat(total - postcard_price))
          }

          document.querySelector('.cart__summary-total').innerHTML = 'Итого: ' + t + ' р.';
        })
      }
    }

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      await Order();

      return false;
    })
  }


})


const review = function (order_id, message) {
  const input = document.querySelector('[data-form-wrapper="leave-review"] form [name="order_id"]');
  input.value = order_id;

  const inputmessage = document.querySelector('[data-form-wrapper="leave-review"] form [name="description"]');
  inputmessage.value = message;
}


const toJson = function (form) {
  let dataData = new FormData(form);
  let body = {};
  for (var [key, value] of dataData.entries()) {
    body[key] = value;
  }
  return body;
}




document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('[data-form-wrapper="leave-review"] form');

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const body = toJson(form);


      const {response, error} = await request(form.getAttribute('action'), form.getAttribute('method'), body);

      if (response) {
        showThanks(document.querySelector("[data-form='leave-review']"))
      }

      return false;
    })
  }
})


document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('[data-form="contact-us"] form');

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const body = toJson(form);


      const {response, error} = await request(form.getAttribute('action'), form.getAttribute('method'), body);

      if (response) {
        showThanks(document.querySelector("[data-form='contact-us']"))
      }

      return false;
    })
  }
})
