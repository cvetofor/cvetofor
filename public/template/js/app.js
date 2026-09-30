/**
 * Прогрессивное улучшение.
 *
 * Страница полностью работоспособна без этого файла:
 *  — элементы, которым нужен JS, размечены атрибутом `hidden`;
 *  — миниатюры галереи это ссылки на файл фотографии, поэтому без скрипта
 *    клик просто открывает снимок.
 * Скрипт лишь делает взаимодействие удобнее и ничего не добавляет к контенту.
 */

/* Маркер версии: по нему видно, какая сборка скрипта реально выполнилась */
document.documentElement.dataset.app = '16';

/* ------------------------------------------- Закрываемые блоки (плашка) */

/* Кнопка закрытия приходит в разметке скрытой и показывается скриптом:
   без JS плашку закрыть нельзя, поэтому и помнить закрытие может только
   скрипт. Ключ из data-dismiss-storage (плашка «Установите приложение»)
   держится в localStorage — закрыли один раз, больше не показываем */
document.querySelectorAll('[data-dismiss]').forEach((button) => {
  const storageKey = button.dataset.dismissStorage;

  if (storageKey && localStorage.getItem(storageKey)) {
    const dismissed = button.closest(button.dataset.dismiss);
    if (dismissed) dismissed.remove();
    return;
  }

  button.hidden = false;

  button.addEventListener('click', () => {
    const target = button.closest(button.dataset.dismiss);
    if (target) target.remove();
    if (storageKey) localStorage.setItem(storageKey, '1');
  });
});

/* ---------------------------------------------------- Галерея товара */

document.querySelectorAll('[data-gallery]').forEach((gallery) => {
  const main = gallery.querySelector('[data-gallery-main]');
  const player = gallery.querySelector('[data-gallery-player]');
  const items = Array.from(gallery.querySelectorAll('[data-gallery-item]'));
  if (!main || items.length < 2) return;

  let current = Math.max(0, items.findIndex((el) => el.hasAttribute('aria-current')));

  const show = (index) => {
    current = (index + items.length) % items.length;
    const item = items[current];
    const thumb = item.querySelector('img');
    const isVideo = item.hasAttribute('data-gallery-video');

    // Видео и фото делят одно место: показываем то, что выбрали
    if (player) {
      player.hidden = !isVideo;
      if (isVideo) player.play().catch(() => {});
      else player.pause();
    }
    main.hidden = isVideo;

    if (!isVideo) {
      main.src = item.getAttribute('href');
      main.alt = thumb ? thumb.alt : '';
    }

    items.forEach((el, i) => {
      el.toggleAttribute('aria-current', i === current);
      el.closest('.gallery__thumb').classList.toggle('is-active', i === current);
    });
  };

  items.forEach((item, index) => {
    item.addEventListener('click', (event) => {
      event.preventDefault();
      show(index);
    });
  });

  // Стрелки видны и без скрипта: там ссылки на соседние снимки. Скрипт
  // только перехватывает клик и перелистывает вместо перехода
  gallery.querySelectorAll('[data-gallery-step]').forEach((button) => {
    button.hidden = false;
    button.addEventListener('click', (event) => {
      event.preventDefault();
      show(current + Number(button.dataset.galleryStep));
    });
  });

  // Автовоспроизведение — только если человек не просил убрать анимацию
  if (player && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    player.autoplay = false;
    player.pause();
  }
});

/* ---------------------------------------------- Оверлеи (меню, город) */

/*
 * Открываются и закрываются скриптом — классом is-open на .overlay.
 * Хеш в URL не пишется: раньше адрес вида «…#city-picker» оставался
 * после закрытия и открывал панель заново при перезагрузке страницы.
 * Ссылки в разметке прежние — клик по ним перехватывается ниже.
 */

const overlays = document.querySelectorAll('.overlay');

let opener = null;

// Всё, что лежит рядом с оверлеями: пока панель открыта, эта часть
// страницы становится inert — иначе Tab уходит под панель, к шести
// десяткам ссылок, которых на экране не видно
const rest = overlays.length
  ? Array.from(document.body.children).filter((el) => !el.matches('.overlay, script'))
  : [];

const setRestInert = (locked) => {
  rest.forEach((el) => { el.inert = Boolean(locked); });
};

const openOverlay = (id) => {
  const next = document.getElementById(id);
  if (!next || !next.matches('.overlay')) return;

  overlays.forEach((el) => { el.classList.remove('is-open'); });
  next.classList.add('is-open');
  setRestInert(true);

  const first = next.querySelector('.overlay__close');
  if (first) first.focus();
};

const closeOverlay = () => {
  if (!document.querySelector('.overlay.is-open')) return;

  overlays.forEach((el) => { el.classList.remove('is-open'); });
  setRestInert(false);

  if (opener) {
    opener.focus();
    opener = null;
  }
};

if (overlays.length) {
  // href="#overlay-id" открывает панель, href="#main" внутри панели
  // (крестик, «Понятно») закрывает. В обоих случаях переход по ссылке
  // отменяем — URL остаётся без хеша
  document.addEventListener('click', (event) => {
    const link = event.target.closest('a[href^="#"]');
    if (!link) return;

    const href = link.getAttribute('href');

    if (link.closest('.overlay') && href === '#main') {
      event.preventDefault();
      closeOverlay();
      return;
    }

    const id = href.slice(1);
    const panel = document.getElementById(id);
    if (panel && panel.matches('.overlay')) {
      event.preventDefault();
      opener = link;
      openOverlay(id);
    }
  });

  overlays.forEach((overlay) => {
    overlay.addEventListener('click', (event) => {
      if (event.target === overlay) closeOverlay();
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeOverlay();
  });

  // В адресе мог остаться хеш от прошлой версии (закладка, открытая
  // вкладка) — вычищаем: теперь он ничего не открывает и только мешает
  if (location.hash) {
    history.replaceState(null, '', location.pathname + location.search);
  }
}

window.Cvetofor = Object.assign(window.Cvetofor || {}, { openOverlay, closeOverlay });

/* --------------------------- Блоки, появляющиеся по действию пользователя */

/*
 * В макете это отдельные фреймы «до» и «после»: баллы UDS появляются после
 * «Проверить баллы», список салонов — после выбора самовывоза. Без скрипта
 * оба состояния приходят с сервера (кнопка отправляет форму), скрипт лишь
 * показывает заранее свёрстанный блок на месте.
 */

/*
 * hidden прячет блок, но не выключает его поля: скрытый <fieldset> с
 * выбранным салоном всё равно уходил в POST при доставке курьером.
 * Поэтому показ и скрытие всегда идут парой hidden + disabled.
 */
const setRevealed = (target, shown) => {
  target.hidden = !shown;
  if ('disabled' in target) target.disabled = !shown;
};

document.querySelectorAll('[data-reveal]').forEach((control) => {
  const target = document.querySelector(control.dataset.reveal);
  if (!target) return;

  // Переключатель: блок виден, пока выбран именно этот вариант.
  // preventDefault здесь нельзя — он не даст переключателю встать.
  if (control.matches('input[type="radio"]')) {
    const sync = () => { setRevealed(target, control.checked); };
    document.querySelectorAll('input[name="' + control.name + '"]')
      .forEach((radio) => radio.addEventListener('change', sync));
    sync();
    return;
  }

  // Кнопка: показываем блок вместо отправки формы
  control.addEventListener('click', (event) => {
    event.preventDefault();
    setRevealed(target, true);
  });
});

/* ==========================================================================
   Всплывающие уведомления
   ========================================================================== */

/*
 * showToast({photo, title, note}) — публичный вызов, доступен как
 * window.Cvetofor.toast(...). Бэкенд может дёргать его после своего
 * ajax-ответа: разметка уведомления лежит в <template>, а не в скрипте.
 */
const toastLayer = document.getElementById('toasts');
const toastTemplate = document.getElementById('toast-template');

function showToast(options) {
  if (!toastLayer || !toastTemplate) return null;

  const node = toastTemplate.content.firstElementChild.cloneNode(true);
  const photo = node.querySelector('.toast__photo');

  if (options.photo) {
    photo.src = options.photo;
    photo.alt = '';
  } else {
    photo.remove();
  }

  node.querySelector('.toast__title').textContent = options.title || '';
  node.querySelector('.toast__note').textContent = options.note || '';

  const close = () => node.remove();
  node.querySelector('.toast__close').addEventListener('click', close);

  toastLayer.append(node);
  // Уведомление живёт 5 секунд: меньше — не успеть прочитать, больше —
  // мешает. Закрыть можно и крестиком.
  setTimeout(close, 5000);
  return node;
}

/* ==========================================================================
   Формы карточки: избранное и «В корзину»
   ========================================================================== */

/*
 * Обе кнопки в карточке — настоящие формы с action и method: без скрипта
 * они просто отправляются на сервер и страница перезагружается. Скрипт
 * перехватывает отправку, шлёт то же самое через fetch и показывает
 * результат на месте.
 */

const postForm = (form) =>
  fetch(form.action, {
    method: (form.method || 'post').toUpperCase(),
    body: new FormData(form),
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  });

/*
 * Обработчик один на весь документ и висит на submit: карточки, пришедшие
 * с сервера аяксом, начинают работать сразу, без повторной инициализации.
 */
document.addEventListener('submit', (event) => {
  const fav = event.target.closest('[data-fav]');
  if (fav) {
    event.preventDefault();

    const button = fav.querySelector('button');
    const on = button.getAttribute('aria-pressed') !== 'true';
    const card = fav.closest('.card');
    const title = (card || document).querySelector('.card__title, .product__title');
    const name = title ? title.textContent.trim() : 'товар';

    // Состояние переключаем сразу: ответ сервера тут ничего не решает,
    // а ждать его — значит показывать «мёртвую» кнопку
    button.setAttribute('aria-pressed', String(on));
    button.setAttribute('aria-label', on
      ? 'Убрать «' + name + '» из избранного'
      : 'Добавить «' + name + '» в избранное');

    postForm(fav).catch(() => {});
    return;
  }

  const add = event.target.closest('[data-cart-add]');
  if (add) {
    event.preventDefault();

    const scope = add.closest('.card') || document;
    const photo = scope.querySelector('.card__photo, [data-cart-photo]');

    postForm(add).catch(() => {});

    showToast({
      photo: photo ? photo.currentSrc || photo.src : '',
      title: 'Добавлено в корзину',
      note: 'В корзину была добавлена одна позиция'
    });
  }
});

window.Cvetofor = Object.assign(window.Cvetofor || {}, { toast: showToast });

/* ==========================================================================
   Каталог: фильтры и «Показать ещё» без перезагрузки
   ========================================================================== */

/*
 * Контракт с бэкендом один на оба случая: сервер отдаёт КУСОК разметки —
 * только <li><article class="card">…</article></li>, без <ul> и без обёрток.
 * Сетка и отступы заданы на самом списке (#products), поэтому пришедшие
 * элементы встают на место и вёрстка не едет.
 *
 *   data-filter                    — форма фильтров: ответ ЗАМЕНЯЕТ список
 *   data-load-more                 — «Показать ещё»: ответ ДОБАВЛЯЕТСЯ в конец
 *   data-target="#products"        — куда класть
 *
 * Обработчики карточек делегированы на document, поэтому новым карточкам
 * ничего инициализировать не нужно.
 */

const listUrl = (form) => {
  const params = new URLSearchParams(new FormData(form));
  return form.action + (form.action.includes('?') ? '&' : '?') + params;
};

async function loadList(form, { append }) {
  const list = document.querySelector(form.dataset.target);
  if (!list) return;

  const button = form.querySelector('button[type="submit"]');
  if (button) button.setAttribute('aria-busy', 'true');

  try {
    const html = await fetch(listUrl(form), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then((response) => {
      if (!response.ok) throw new Error(response.status);
      return response.text();
    });

    if (append) {
      list.insertAdjacentHTML('beforeend', html);
      // Пустой ответ = страниц больше нет, кнопку убираем
      if (!html.trim()) form.remove();
      else {
        const page = form.elements.page;
        if (page) page.value = String(Number(page.value) + 1);
      }
    } else {
      list.innerHTML = html;
    }
  } catch (error) {
    // Сеть отвалилась или сервер ответил ошибкой — уходим на обычную
    // отправку формы, чтобы человек всё-таки увидел результат
    form.submit();
  } finally {
    if (button) button.removeAttribute('aria-busy');
  }
}

document.addEventListener('submit', (event) => {
  const more = event.target.closest('[data-load-more]');
  if (more) {
    event.preventDefault();
    loadList(more, { append: true });
    return;
  }

  const filter = event.target.closest('[data-filter]');
  if (filter && document.querySelector(filter.dataset.target)) {
    event.preventDefault();
    loadList(filter, { append: false });
  }
});

/* Фильтры применяются сразу по смене значения — кнопки «Показать» в макете
   нет, а без этого форма отправлялась бы только по Enter */
document.querySelectorAll('[data-filter] select').forEach((select) => {
  select.addEventListener('change', () => {
    select.form.requestSubmit
      ? select.form.requestSubmit()
      : select.form.dispatchEvent(new Event('submit', { cancelable: true }));
  });
});

/* ==========================================================================
   Интервалы доставки зависят от даты
   ========================================================================== */

/*
 * Дата меняется — состав и количество интервалов приходят с сервера
 * (их число в разные дни разное). Ответ содержит только <li> для
 * списка #slots. Без скрипта то же самое делает кнопка «Обновить время».
 */

const slotsList = document.getElementById('slots');

if (slotsList) {
  const refresh = document.querySelector('[data-slots-refresh]');
  if (refresh) refresh.hidden = true;

  const reload = async (source) => {
    const form = source.form;
    const params = new URLSearchParams(new FormData(form));
    slotsList.setAttribute('aria-busy', 'true');

    try {
      const html = await fetch('/checkout/slots?' + params, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      }).then((response) => {
        if (!response.ok) throw new Error(response.status);
        return response.text();
      });
      if (html.trim()) slotsList.innerHTML = html;
    } catch (error) {
      // Сервер недоступен — оставляем то, что уже показано:
      // терять выбранный интервал из-за сетевой ошибки нельзя
    } finally {
      slotsList.removeAttribute('aria-busy');
    }
  };

  document.querySelectorAll('[data-slots-source]').forEach((source) => {
    source.addEventListener('change', () => reload(source));
  });
}

/* ==========================================================================
   Ошибки полей формы
   ========================================================================== */

/*
 * Публичный API для бэкенда:
 *
 *   Cvetofor.setFieldError('customer-name', 'Введите фамилию и имя');
 *   Cvetofor.clearFieldError('customer-name');
 *   Cvetofor.setFormErrors(form, {'customer-name': 'Текст', city: 'Текст'});
 *
 * Первый аргумент — id поля (или сам элемент). То же самое можно отдать
 * сразу разметкой с сервера: класс is-error на .field-wrap и <p
 * class="field-error" id="<id>-error"> следом. Скрипт и сервер дают
 * одинаковый DOM, поэтому стили одни на оба случая.
 */

function fieldOf(target) {
  return typeof target === 'string' ? document.getElementById(target) : target;
}

function setFieldError(target, message) {
  const field = fieldOf(target);
  if (!field) return null;

  const wrap = field.closest('.field-wrap, .note-wrap, .paired') || field.parentElement;
  wrap.classList.add('is-error');
  field.setAttribute('aria-invalid', 'true');

  const id = (field.id || field.name) + '-error';
  let note = document.getElementById(id);

  if (!note) {
    note = document.createElement('p');
    note.className = 'field-error';
    note.id = id;
    note.innerHTML = '<img src="template/assets/icons/field-error.svg" alt="" width="20" height="20">';
    note.append(document.createTextNode(''));
    wrap.after(note);
  }

  note.lastChild.textContent = ' ' + message;
  field.setAttribute('aria-describedby', id);
  return note;
}

function clearFieldError(target) {
  const field = fieldOf(target);
  if (!field) return;

  const wrap = field.closest('.field-wrap, .note-wrap, .paired') || field.parentElement;
  wrap.classList.remove('is-error');
  field.removeAttribute('aria-invalid');

  const note = document.getElementById((field.id || field.name) + '-error');
  if (note) note.remove();
  field.removeAttribute('aria-describedby');
}

function setFormErrors(form, errors) {
  const root = typeof form === 'string' ? document.querySelector(form) : form;
  if (!root) return;

  // Сначала снимаем прошлые ошибки: иначе исправленное поле остаётся красным
  root.querySelectorAll('[aria-invalid="true"]').forEach(clearFieldError);
  Object.keys(errors).forEach((name) => {
    setFieldError(root.querySelector('#' + name + ', [name="' + name + '"]'), errors[name]);
  });
}

/* Человек начал исправлять — ошибка уходит сразу, не дожидаясь отправки */
document.addEventListener('input', (event) => {
  if (event.target.getAttribute('aria-invalid') === 'true') clearFieldError(event.target);
});

/*
 * Проверка вёрстки без бэкенда: ?errors=1 подсвечивает все обязательные
 * поля текстом из макета, ?errors=customer-name:Свой текст — конкретное.
 */
const errorsParam = new URLSearchParams(location.search).get('errors');
if (errorsParam) {
  if (errorsParam === '1') {
    document.querySelectorAll('[required]').forEach(
      (field) => setFieldError(field, 'Поле обязательно к заполнению'));
  } else {
    errorsParam.split(';').forEach((pair) => {
      const [name, text] = pair.split(':');
      setFieldError(document.querySelector('#' + name + ', [name="' + name + '"]'),
        text || 'Поле обязательно к заполнению');
    });
  }
}

window.Cvetofor = Object.assign(window.Cvetofor || {},
  { setFieldError, clearFieldError, setFormErrors });


/* ==================================================== Смотрите также ==== */
/* Слайдер [data-slider]: стрелки [data-slider-prev]/[data-slider-next]
   листают ленту на ширину одной карточки с её зазором */
document.querySelectorAll('[data-slider]').forEach((track) => {
  const root = track.closest('.see-also') || document;
  const prev = root.querySelector('[data-slider-prev]');
  const next = root.querySelector('[data-slider-next]');
  if (!prev || !next) return;

  const step = () => {
    const card = track.querySelector(':scope > li');
    if (!card) return track.clientWidth;
    const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
    return card.getBoundingClientRect().width + gap;
  };

  const update = () => {
    const max = track.scrollWidth - track.clientWidth - 1;
    prev.disabled = track.scrollLeft <= 0;
    next.disabled = track.scrollLeft >= max;
  };

  prev.addEventListener('click', () => track.scrollBy({ left: -step() }));
  next.addEventListener('click', () => track.scrollBy({ left: step() }));
  track.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
  update();
});


/* ============================================ Объединённый checkout ==== */
/* Страница checkout: переключение четырёх шагов без перезагрузки.
   Переходы между шагами локальные, без запросов — action у форм шагов
   1–3 не используется. Единственный сетевой вызов — финальный POST на
   order.create с полями формы старого дизайна (состав поля задан явно
   в buildOrderPayload ниже). */

(() => {
  const root = document.querySelector('.checkout-step');
  if (!root) return;

  const steps = Array.from(document.querySelectorAll('.checkout-step'));
  const nav = document.querySelector('.steps-wrap');
  const bar = nav ? nav.querySelector('.steps__bar') : null;
  const percent = nav ? nav.querySelector('.steps__percent') : null;
  const stepItems = nav ? Array.from(nav.querySelectorAll('ol.steps > li.step')) : [];
  const submitBtn = document.querySelector('[data-submit-for]');
  // согласие на обработку ПД — видно только на шаге 4, у финальной кнопки
  const consent = document.querySelector('.checkout__consent');
  const DONE_ICON = 'template/assets/icons/checkmark.svg';

  const PROGRESS = { 1: 25, 2: 50, 3: 75, 4: 100 };
  let current = 1;

  const show = (n) => {
    current = n;
    steps.forEach((el) => { el.hidden = Number(el.dataset.step) !== n; });

    if (bar) {
      bar.value = PROGRESS[n];
      bar.textContent = PROGRESS[n] + ' %';
    }
    if (percent) percent.textContent = PROGRESS[n] + '\u00a0%';

    stepItems.forEach((li, i) => {
      const num = li.querySelector('.step__num');
      li.classList.toggle('is-done', i + 1 < n);
      li.classList.toggle('is-current', i + 1 === n);
      if (i + 1 === n) li.setAttribute('aria-current', 'step');
      else li.removeAttribute('aria-current');
      if (num) {
        num.innerHTML = (i + 1 < n)
          ? `<img src="${DONE_ICON}" alt="" width="28" height="28"><span class="visually-hidden">Шаг ${i + 1}, пройден</span>`
          : String(i + 1);
      }
    });

    if (submitBtn) {
      const form = document.getElementById('checkout-step-' + n);
      if (form) submitBtn.setAttribute('form', form.id);
      const label = submitBtn.querySelector('.checkout__submit-label');
      if (label) label.textContent = (n === 4) ? 'Оформить заказ' : 'Далее';
    }

    // согласие на обработку ПД показывается вместе с кнопкой «Оформить заказ»
    if (consent) consent.hidden = n !== 4;

    if (n === 4) refreshReview();
    document.getElementById('main').scrollIntoView({ behavior: 'smooth' });
  };

  // ===== Финальная отправка: поля 1-в-1 со старым дизайном =====
  // Контракт взят из формы order.blade.php и Order() в public/dist/js/
  // backend-temp.js: JSON-POST на order.create через request() (CSRF —
  // в заголовке, как у старого request()). Каждая строка карты ниже —
  // одно поле старой формы с источником значения; правьте под себя.

  const checkoutRoot = document.querySelector('.checkout');

  // значение поля по name из любой формы шагов; для радиокнопок
  // (payment_id, delivery_time) берётся отмеченная
  const field = (name) => {
    const el = checkoutRoot.querySelector('[name="' + name + '"]:checked')
      || checkoutRoot.querySelector('[name="' + name + '"]');
    return el ? String(el.value || '').trim() : '';
  };

  // чекбоксы уходят как «on» только в отмеченном состоянии — ровно как
  // их сериализует FormData (неотмеченный в payload не попадает)
  const checkbox = (name) => {
    const el = checkoutRoot.querySelector('[name="' + name + '"]');
    return (el && el.checked) ? 'on' : null;
  };

  // старая форма держала город и улицу одним полем: значение целиком
  // писала подсказка яндекс-карт — «г Улан-Удэ, ул …, д …», без региона.
  // Здесь собираем такую же строку из двух полей шага 1: город из #city
  // + улица (если она уже начинается с города — не дублируем)
  const fullAddress = () => {
    const input = checkoutRoot.querySelector('[name="address"]');
    const street = input ? input.value.trim() : '';
    if (!street) return street;
    const city = field('city');
    if (!city) return street;
    return street.toLowerCase().startsWith(city.toLowerCase())
      ? street
      : 'г ' + city + ', ' + street;
  };

  const buildOrderPayload = () => {
    const payload = {
      // — доставка —
      address: fullAddress(),                        // «регион, город, улица…»
      apartament_number: field('apartament_number'), // поля в новой вёрстке нет → ''
      // — получатель —
      person_receiving_name: field('person_receiving_name'),
      person_receiving_phone: field('person_receiving_phone'),
      // — дата и время (шаг 2): те же форматы, что уходили со старой
      // формой — «ДД.ММ.ГГГГ» (flatpickr) и «10:00 - 12:00» (слоты)
      delivery_date: field('delivery_date'),
      delivery_time: field('delivery_time'),
      // — заказчик —
      fio: field('fio'),
      email2: field('email2'),
      phone: field('phone'),
      comment: field('comment'),
      // — переключатели шага 1 —
      postcard: checkbox('postcard'),
      postcard_text: field('postcard_text'),
      is_anon: checkbox('is_anon'),
      // чекбокса «фотоотчёт» в новой вёрстке нет: добавите поле
      // name="is_photo_needle" — начнёт уходить само
      is_photo_needle: checkbox('is_photo_needle'),
      // — шаг 3 —
      payment_id: field('payment_id'),
      uds_promo: field('uds_promo'),
      promocode: field('promocode'),
      // согласие на обработку ПД: чекбокс под кнопкой «Оформить заказ»
      // (шаг 4, required — без отметки форма не отправится)
      pdn: checkbox('pdn'),
    };

    // координаты выбранного адреса: их пишет блок подсказок DaData в
    // dataset поля (аналог геокода яндекс-карт в старом Order()).
    // Только когда поля адреса видимы; строкой «lat,lon» — именно в таком
    // виде значение проходило через FormData старой формы, и так его ждёт
    // OrderRequest::checkRadius (explode(','))
    const addressFields = document.querySelector('[data-address-fields]');
    const addressInput = checkoutRoot.querySelector('[data-delivery-address]');
    if (addressFields && !addressFields.hidden && addressInput
      && addressInput.dataset.deliveryLat && addressInput.dataset.deliveryLon) {
      payload.coordinates = addressInput.dataset.deliveryLat + ',' + addressInput.dataset.deliveryLon;
    }

    // Оплата по счёту (способ с data-account): старый дизайн открывал
    // модалку реквизитов и прикладывал legal_account JSON-строкой. В новой
    // вёрстке модалки нет — при необходимости добавьте поле:
    // payload.legal_account = JSON.stringify({ recipient: '…', bik: '…' });

    // null-ключи (неотмеченные чекбоксы) не отправляются — как в FormData
    Object.keys(payload).forEach((key) => {
      if (payload[key] === null) delete payload[key];
    });
    return payload;
  };

  // «Далее» открывает следующий шаг; на шаге 4 — финальная отправка
  steps.forEach((wrap) => {
    const form = wrap.querySelector('form');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const n = Number(wrap.dataset.step);

      // без выбранной даты и времени доставки дальше не пускаем
      if (n === 2) {
        const dateValue = (document.getElementById('date') || {}).value || '';
        const slotChecked = form.querySelector('input[name="delivery_time"]:checked');
        const deliveryError = document.querySelector('[data-delivery-error]');
        if (!dateValue.trim() || !slotChecked) {
          console.warn('delivery check failed:', { date: dateValue, slotSelected: !!slotChecked });
          if (deliveryError) {
            deliveryError.hidden = false;
            deliveryError.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
          return;
        }
        if (deliveryError) {
          deliveryError.hidden = true;
        }
      }

      // шаги 1–3 переходят локально, без сети: единственный запрос —
      // финальный POST на order.create
      if (n < 4) {
        show(n + 1);
        return;
      }

      // финал: данные всех шагов одним POST на order.create (action формы
      // шага 4) — тот же контракт, что у формы старого дизайна
      const payload = buildOrderPayload();
      let result;
      try {
        result = await request(form.action, form.method, payload);
      } catch (_) {
        // сеть недоступна — заказ не создан, говорим об этом
        window.Cvetofor.toast({
          title: 'Не удалось оформить заказ',
          note: 'Сервер недоступен, попробуйте ещё раз'
        });
        return;
      }
      const { response, error } = result;

      if (response && typeof response === 'object' && response.order_id) {
        if (response.redirect) {
          window.location.href = response.redirect;
        } else {
          // редиректа нет (оплата не онлайн) — заказ всё равно создан
          window.Cvetofor.toast({
            title: 'Заказ оформлен',
            note: 'Номер заказа: ' + response.order_id
          });
        }
        return;
      }

      if (error) {
        // адрес вне зоны доставки: сервер отвечает 400 + modal=delivery-area
        if (error.modal === 'delivery-area') {
          const text = document.querySelector('[data-delivery-area-text]');
          if (text) {
            text.textContent = error.message ||
              'По выбранному адресу доставка недоступна. Попробуйте другой адрес.';
          }
          window.Cvetofor.openOverlay('delivery-area');
          return;
        }

        // ошибки валидации OrderRequest: подпись под полем + возврат
        // на шаг, где стоит это поле
        if (error.errors) {
          Object.keys(error.errors).forEach((name) => {
            const input = checkoutRoot.querySelector('[name="' + name + '"]');
            if (!input) return;
            window.Cvetofor.setFieldError(input, error.errors[name][0]);
            const step = input.closest('[data-step]');
            if (step) show(Number(step.dataset.step));
          });
          return;
        }

        if (error.message) {
          window.Cvetofor.toast({ title: 'Не удалось оформить заказ', note: error.message });
        }
        return;
      }

      // не JSON (например, страница 419) — старый дизайн этот случай молчал
      console.warn('order.create: unexpected response', response);
    });
  });

  // клик по цифрам шагов: можно вернуться на пройденный шаг
  stepItems.forEach((li, i) => {
    li.style.cursor = 'pointer';
    li.addEventListener('click', () => { if (i + 1 < current) show(i + 1); });
  });


  // Шаг 4 заполняется из значений шагов 1-3; обновляется при входе на шаг
  // и перед финальной отправкой
  const val = (id) => {
    const el = document.getElementById(id);
    return el ? el.value.trim() : '';
  };

  const checkedLabel = (name) => {
    const input = document.querySelector('input[name="' + name + '"]:checked')
      || document.querySelector('input[type="hidden"][name="' + name + '"]');
    if (!input) return '';
    const label = document.querySelector('label[for="' + input.id + '"]');
    return label ? label.textContent.replace(/\s+/g, ' ').trim() : '';
  };

  const fill = (key, text) => {
    const el = document.querySelector('[data-fill="' + key + '"]');
    if (el) el.textContent = text;
  };

  const refreshReview = () => {
    // заказчик
    fill('customer-name', val('customer-name') || '—');
    fill('customer-phone', val('customer-phone') || '—');

    // адрес (если «не знаю адрес» — поля скрыты)
    const fields = document.querySelector('[data-address-fields]');
    const addressHidden = fields && fields.hidden;
    if (addressHidden) {
      fill('address', 'Адрес не указан — фиксированная оплата доставки');
    } else {
      const city = document.getElementById('city');
      const cityName = city
        ? (city.selectedOptions && city.selectedOptions[0]
          ? city.selectedOptions[0].text.trim()
          : city.value.trim())
        : '';
      fill('address', 'г. ' + cityName + ', ' + (val('address') || '—'));
    }

    // способ и время доставки
    // способ может быть и скрытым полем (type=hidden без :checked)
    const way = document.querySelector('input[name="way"]:checked')
      || document.querySelector('input[name="way"]');
    const isPickup = way && way.id === 'way-pickup';
    let wayTitle = '';
    if (way) {
      const t = document.querySelector('label[for="' + way.id + '"] .way__title');
      wayTitle = t ? t.textContent : way.value;
    }
    fill('way', wayTitle.trim() || '—');
    if (isPickup) {
      const salon = document.querySelector('input[name="salon"]:checked');
      const salonTitle = salon
        ? document.querySelector('label[for="' + salon.id + '"] .salon__name')
        : null;
      fill('date', salonTitle ? salonTitle.textContent.trim() : 'Самовывоз');
      fill('slot', 'Самовывоз из салона');
    } else {
      const day = document.querySelector('input[name="day"]:checked');
      let dayText = '';
      if (day) {
        const label = document.querySelector('label[for="' + day.id + '"]');
        if (label) {
          const t = label.querySelector('.daychip__title');
          const d = label.querySelector('.daychip__date');
          dayText = [t && t.textContent.trim(), d && d.textContent.trim()].filter(Boolean).join(', ');
        }
      }
      const custom = val('date');
      fill('date', custom || dayText || '—');
      fill('slot', checkedLabel('delivery_time') || '—');
    }

    // оплата
    const pay = document.querySelector('input[name="payment_id"]:checked');
    if (pay) {
      const label = document.querySelector('label[for="' + pay.id + '"]');
      fill('payment', label ? (label.querySelector('.pay__title') || {}).textContent || '' : '');
      const note = label ? (label.querySelector('.pay__note') || {}).textContent || '' : '';
      fill('payment-note', note);
    }

    // дополнительно
    const postcard = document.getElementById('postcard');
    const anon = document.getElementById('anon');
    const liPostcard = document.querySelector('[data-extra="postcard"]');
    const liAnon = document.querySelector('[data-extra="anon"]');
    const card = document.querySelector('[data-extra="postcard-text"]');
    if (liPostcard) liPostcard.hidden = !(postcard && postcard.checked);
    if (liAnon) liAnon.hidden = !(anon && anon.checked);
    fill('extra-anon', (anon && anon.checked) ? 'Анонимная доставка' : '');
    const text = val('postcard_text');
    if (card) card.hidden = !(postcard && postcard.checked && text);
    fill('postcard-text', text);

    // примечания
    const note = val('comment');
    fill('note', note || 'Примечаний нет');
  };


  // Дата и время (daychips + календарь) ведутся одним блоком календаря
  // доставки в конце файла: он один пишет в поле #date (ДД.ММ.ГГГГ),
  // синхронизирует чипы и обновляет подпись «Выбрать дату»

  // «Изменить» на шаге подтверждения открывает соответствующий шаг
  document.querySelectorAll('[data-edit-step]').forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      show(Number(link.dataset.editStep));
    });
  });

  // стрелка «назад» (мобильная): на шагах 2-4 возвращает на шаг назад,
  // на первом шаге ведёт в корзину
  const back = document.querySelector('.page-head__back');
  if (back) {
    back.addEventListener('click', (e) => {
      if (current > 1) {
        e.preventDefault();
        show(current - 1);
      }
    });
  }
})();


/* ===================================================== Маска телефона ==== */
/* Всем полям с классом .js-phone формат ввода приводится к
   +7 (999) 999-99-99 на лету, независимо от страницы */
document.querySelectorAll('input.js-phone').forEach((input) => {
  const format = () => {
    let digits = input.value.replace(/\D/g, '');
    if (!digits) { input.value = ''; return; }
    if (digits[0] === '8' || digits[0] === '9') digits = '7' + digits.slice(1);
    if (digits[0] !== '7') digits = '7' + digits;
    digits = digits.slice(0, 11);

    let out = '+7';
    if (digits.length > 1) out += ' (' + digits.slice(1, 4);
    if (digits.length >= 4) out += ') ' + digits.slice(4, 7);
    if (digits.length >= 7) out += '-' + digits.slice(7, 9);
    if (digits.length >= 9) out += '-' + digits.slice(9, 11);
    input.value = out;
  };

  input.addEventListener('input', format);
  input.addEventListener('focus', () => {
    if (!input.value) input.value = '+7 (';
  });
  input.addEventListener('blur', () => {
    if (input.value === '+7 (' || input.value === '+7') input.value = '';
  });
});


/* ====================================== Получатель и заказчик — одно лицо ==== */
/* Пока включена галочка #same-person: при вводе имени/телефона заказчика
   значения автоматически дублируются в поля получателя, а само включение
   галочки сразу копирует текущие значения. Выключение ничего не меняет. */
(() => {
  const check = document.getElementById('same-person');
  if (!check) return;

  const pairs = [
    ['customer-name', 'recipient-name'],
    ['customer-phone', 'recipient-phone'],
  ];

  const copyAll = () => {
    if (!check.checked) return;
    pairs.forEach(([from, to]) => {
      const src = document.getElementById(from);
      const dst = document.getElementById(to);
      if (src && dst) dst.value = src.value;
    });
  };

  pairs.forEach(([from]) => {
    const src = document.getElementById(from);
    if (src) src.addEventListener('input', copyAll);
  });

  check.addEventListener('change', copyAll);
})();


/* ================================================== Текст для открытки ==== */
/* Поле postcard_text показывается при включённой галочке #postcard,
   при выключении скрывается и очищается */
(() => {
  const check = document.getElementById('postcard');
  const row = document.getElementById('postcard-text-row');
  if (!check || !row) return;
  const field = document.getElementById('postcard_text');

  check.addEventListener('change', () => {
    row.hidden = !check.checked;
    if (!check.checked && field) field.value = '';
  });
})();


/* ============================================== «Не знаю адрес» ==== */
/* Кнопка data-address-unknown скрывает поля адреса (data-address-fields)
   и снимает с них required, кнопка data-address-known возвращает */
(() => {
  const known = document.querySelector('[data-address-known]');
  const unknown = document.querySelector('[data-address-unknown]');
  const fields = document.querySelector('[data-address-fields]');
  if (!known || !unknown || !fields) return;

  const setActive = (knows) => {
    known.classList.toggle('is-active', knows);
    known.setAttribute('aria-pressed', String(knows));
    unknown.classList.toggle('is-active', !knows);
    unknown.setAttribute('aria-pressed', String(!knows));
    fields.hidden = !knows;
    fields.querySelectorAll('input, select').forEach((el) => {
      el.disabled = !knows;
    });
  };

  known.addEventListener('click', () => setActive(true));

  // «Не знаю адрес» сначала показывает предупреждение,
  // поля скрываются только после «Принимаю»
  unknown.addEventListener('click', () => {
    window.Cvetofor.openOverlay('no-address');
  });

  const accept = document.querySelector('[data-accept-no-address]');
  if (accept) {
    accept.addEventListener('click', () => {
      setActive(false);
      window.Cvetofor.closeOverlay();
    });
  }
})();

document.addEventListener("DOMContentLoaded", () => PutToCart());
// Кнопка добавить в корзине
const PutToCart = function () {

  const cartButtons = document.querySelectorAll('[data-put-cart-sku],[data-cart-additional-item-add],[data-cart-additional-item-add-cat]');

  if (cartButtons) {
    cartButtons.forEach(function (button) {
      button.addEventListener('click', async function (e) {

        let sku = '';
        let link = window['cvetofor'].config.routes.cart.put;

        if (button.getAttribute('data-cart-additional-item-add')) {
          sku = button.getAttribute('data-id');
          link = window['cvetofor'].config.routes.cart.putAdditional;
        }else{
          if (button.getAttribute('data-cart-additional-item-add-cat')) {
            sku = button.getAttribute('data-id');
            link = window['cvetofor'].config.routes.cart.putAdditional;
          } else {
            sku = button.getAttribute('data-put-cart-sku');
          }


        }




        shareLastSku = sku;

        const {response, error} = await request(link(sku), "PUT");

        if (response) {
          if (button.getAttribute('data-cart-additional-item-add')) {
            window.location.reload();
          }




          const scope = button.closest('.card');
          const photo = (scope || document).querySelector('.card__photo, [data-cart-photo]');

          showToast({
            photo: photo ? photo.currentSrc || photo.src : '',
            title: 'Добавлено в корзину',
            note: 'В корзину была добавлена одна позиция'
          });





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

function setCounter(count) {

  let cartCounters = document.querySelectorAll('.icon-btn__counter');
  cartCounters.forEach(e => {
    e.innerHTML = count;
  });
}
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
const LoadMore = function (child = null) {

  const dom = child ? child : document;

  if (!dom.querySelector("[data-category-items]")) return;

  dom.querySelectorAll("[data-category-items]").forEach(function (item) {
    const btnMore = item.querySelector("[data-load-more]") ||
      item.parentNode.querySelector("[data-load-more]");

    if (btnMore && !btnMore.dataset.loadMoreBound) {
      btnMore.dataset.loadMoreBound = "1";

      btnMore.addEventListener("click", async function (e) {
        e.preventDefault();

        btnMore.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        btnMore.setAttribute('disabled', 'disabled');
        const { response, error } = await request(btnMore.getAttribute('href'));

        if (error) {
          btnMore.innerHTML = 'Показать ещё';
          btnMore.removeAttribute('disabled');
          return;
        }

        const wrap = btnMore.closest('.products__more-wrap');
        btnMore.remove();
        if (wrap) wrap.remove();

        // JSON: { data: { category_N: "<li>…</li>" } }; обычный HTML — тоже сработает
        const html = (response && response.data)
          ? response.data[item.dataset.categoryItems]
          : response;
        if (!html) return;

        item.insertAdjacentHTML('beforeend', html);

        // следующая кнопка внутри фрагмента — выносим после <ul> и биндим
        const next = item.querySelector('.products__more-wrap');
        if (next) {
          item.insertAdjacentElement('afterend', next);
          LoadMore(item.parentNode);
        }
      });
    }
  });

};
document.addEventListener("DOMContentLoaded", () => LoadMore());
document.addEventListener('change', (event) => {
  const select = event.target.closest('#sort');
  if (!select) return;

  const url = new URL(window.location.href);

  // убираем прежнюю сортировку, чтобы не осталось второй при переключении
  url.searchParams.delete('order[title]');
  url.searchParams.delete('order[price]');

  // new → сортировка по названию, остальное — по цене
  const key = select.value === 'new' ? 'order[title]' : 'order[price]';
  url.searchParams.set(key, 'desc');

  // если на странице есть пагинация — сортировать логично с первой страницы
  url.searchParams.delete('page');

  window.location.assign(url.href); // редирект
});

/* Клик по городу */
document.addEventListener('DOMContentLoaded', () => {

  const showCityLoading = () => {
    const panel = document.querySelector('.city-modal');
    if (!panel || panel.querySelector('.cities-loading')) return;

    const loader = document.createElement('div');
    loader.className = 'cities-loading';
    loader.innerHTML = `
      <img src="/dist/img/image/logo.svg" alt="" class="cities-loading__logo">
      <div class="cities-loading__text">Идёт загрузка...</div>`;
    panel.appendChild(loader);
  };

  document.querySelectorAll('.city-list__link').forEach((el) => {
    el.addEventListener('click', async function () {

      // сбрасываем цвет у всех
      document.querySelectorAll('.city-list__link')
        .forEach((i) => i.style.color = '');

      // задаём цвет текущему
      this.style.color = '#ca4592';

      // только мобилка
      if (window.matchMedia('(max-width: 768px)').matches) {
        showCityLoading();
      }

      const url = window.cvetofor.config.routes.cities.set(this.dataset.cityId);
      const { response, error } = await request(url, 'POST');

      if (response) {
        document.querySelector('.city__name').textContent = response.name;
        window.location.reload();
      } else if (error) {
        document.querySelector('.cities-loading')?.remove(); // ошибка — убрать лоадер
      }
    });
  });
});


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


document.addEventListener("DOMContentLoaded", function () {
  const deliveryAddress = document.querySelector("[data-delivery-address]");
  const suggestDropdown = document.querySelector("[data-suggest-dropdown]");

  if (!deliveryAddress || !suggestDropdown) {
    return;
  }

  // Город берём из соседнего поля (селектор — в data-suggest-city адресного
  // поля): он уходит в DaData вместе с вводом, а из подсказок вырезается
  const citySelector = deliveryAddress.getAttribute("data-suggest-city");
  const cityInput = citySelector ? document.querySelector(citySelector) : null;

  // «Респ Бурятия, г Улан-Удэ, ул Ленина, д 5» → «ул Ленина, д 5»
  const stripCity = function (item, city) {
    const parts = (item.value || "").split(", ");

    const data = item.data || {};
    const drop = [
      data.region, data.region_with_type,
      data.city, data.city_with_type,
      data.city_district, data.city_district_with_type,
      data.settlement, data.settlement_with_type
    ].filter(Boolean).map(function (s) {
      return s.toLowerCase();
    });

    while (parts.length > 1 && drop.indexOf(parts[0].toLowerCase()) !== -1) {
      parts.shift();
    }

    const cityLower = city.toLowerCase();
    while (parts.length > 1 && parts[0].toLowerCase().indexOf(cityLower) !== -1) {
      parts.shift();
    }

    return parts.join(", ");
  };

  const dadataUrl =
    "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";

  const dadataToken = "5e92644e9396e1985e27534dd409a1fabb19904b";

  let timeout = null;
  let controller = null;

  deliveryAddress.addEventListener("input", function () {
    const value = this.value.trim();
    const city = cityInput ? cityInput.value.trim() : "";

    // текст изменился — координаты прошлой подсказки больше неактуальны
    delete deliveryAddress.dataset.deliveryLat;
    delete deliveryAddress.dataset.deliveryLon;

    clearTimeout(timeout);

    if (controller) {
      controller.abort();
      controller = null;
    }

    if (value.length < 3) {
      suggestDropdown.innerHTML = "";
      suggestDropdown.style.display = "none";
      return;
    }

    timeout = setTimeout(() => {
      controller = new AbortController();

      fetch(dadataUrl, {
        method: "POST",
        mode: "cors",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization": "Token " + dadataToken
        },
        body: JSON.stringify({
          query: city ? city + ", " + value : value,
          count: 5,

          // Только до дома
          from_bound: {
            value: "region"
          },
          to_bound: {
            value: "house"
          }
        }),
        signal: controller.signal
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("DaData API error");
          }

          return response.json();
        })
        .then((result) => {
          const items = result.suggestions || [];

          suggestDropdown.innerHTML = "";

          if (!items.length) {
            suggestDropdown.style.display = "none";
            return;
          }

          const suggest = document.createElement("div");

          suggest.className =
            "ymaps-2-1-79-search__suggest";

          items.forEach((item) => {
            const suggestItem = document.createElement("div");

            suggestItem.className =
              "ymaps-2-1-79-suggest-item";

            const text = document.createElement("div");

            text.className =
              "ymaps-2-1-79-search__suggest-item";

            const withoutCity = stripCity(item, city);

            text.textContent = withoutCity;

            suggestItem.appendChild(text);

            suggestItem.addEventListener("click", function () {
              deliveryAddress.value = withoutCity;

              deliveryAddress.dataset.deliveryAddress =
                withoutCity;

              // Координаты подсказки — для проверки зоны доставки
              // (deliveryRadius), их читает пересчёт из блока календаря
              const geo = item.data || {};
              if (geo.geo_lat && geo.geo_lon) {
                deliveryAddress.dataset.deliveryLat = geo.geo_lat;
                deliveryAddress.dataset.deliveryLon = geo.geo_lon;
              } else {
                delete deliveryAddress.dataset.deliveryLat;
                delete deliveryAddress.dataset.deliveryLon;
              }

              suggestDropdown.innerHTML = "";
              suggestDropdown.style.display = "none";

              deliveryAddress.dispatchEvent(
                new Event("change", {
                  bubbles: true
                })
              );
            });

            suggest.appendChild(suggestItem);
          });

          suggestDropdown.appendChild(suggest);

          suggestDropdown.style.display = "block";
        })
        .catch((error) => {
          if (error.name !== "AbortError") {
            console.error("DaData:", error);
          }
        });
    }, 300);
  });

  deliveryAddress.addEventListener("change", function () {
    deliveryAddress.dataset.deliveryAddress = this.value;
  });

  // Клик по подсказке: mousedown срабатывает раньше blur — по нему
  // понимаем, что адрес сейчас выберут из списка, и геокод на blur не нужен
  let pickingSuggest = false;
  suggestDropdown.addEventListener("mousedown", function () {
    pickingSuggest = true;
  });

  // Уход с поля: геокодируем введённый текст тем же DaData — координаты
  // нужны проверке зоны доставки. Как ymaps-геокод на blur в старом
  // дизайне: срабатывает и когда подсказку не выбрали — кликнули мимо
  // списка или ушли табом
  deliveryAddress.addEventListener("blur", function () {
    const value = this.value.trim();
    const picking = pickingSuggest;
    pickingSuggest = false;

    if (value.length < 3 || deliveryAddress.dataset.deliveryLat || picking) {
      return;
    }

    const city = cityInput ? cityInput.value.trim() : "";

    fetch(dadataUrl, {
      method: "POST",
      mode: "cors",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Token " + dadataToken
      },
      body: JSON.stringify({
        query: city ? city + ", " + value : value,
        count: 1,
        from_bound: {
          value: "region"
        },
        to_bound: {
          value: "house"
        }
      })
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("DaData API error");
        }

        return response.json();
      })
      .then((result) => {
        const first = (result.suggestions || [])[0];
        const geo = (first && first.data) || {};

        if (geo.geo_lat && geo.geo_lon) {
          deliveryAddress.dataset.deliveryLat = geo.geo_lat;
          deliveryAddress.dataset.deliveryLon = geo.geo_lon;

          // пересчёт доставки пойдёт по change, как у выбора подсказки
          deliveryAddress.dispatchEvent(
            new Event("change", {
              bubbles: true
            })
          );
        }
      })
      .catch((error) => {
        // геокод не удался — координат нет, цены остаются прежними
        console.error("DaData geocode:", error);
      });
  });

  document.addEventListener("click", function (event) {
    if (
      event.target !== deliveryAddress &&
      !suggestDropdown.contains(event.target)
    ) {
      suggestDropdown.innerHTML = "";
      suggestDropdown.style.display = "none";
    }
  });
});

// Счётчик символов у textarea комментариев. Лимит — maxlength самого
// поля (сейчас 200), он же не даёт ввести больше
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".note-wrap").forEach(function (wrap) {
    const input = wrap.querySelector(".note-wrap__input");
    const counter = wrap.querySelector(".note-wrap__counter");

    if (!input || !counter) {
      return;
    }

    const max = input.maxLength > 0 ? input.maxLength : 200;

    const update = function () {
      counter.textContent = input.value.length + "/" + max;
    };

    input.addEventListener("input", update);
    update();
  });
});

// Дата и время доставки в чекауте: свой календарь без библиотек.
// Интервалы берутся из config.flatpickr.times/todayTimes/dates, которые
// сервер вшил в страницу (тот же источник, что в старом дизайне) —
// по сети ничего не запрашивается
document.addEventListener("DOMContentLoaded", function () {
  const dateInput = document.getElementById("date");
  const calendarWrap = document.querySelector(".calendar");
  const grid = document.querySelector(".calendar__grid");
  const details = document.querySelector("[data-calendar]");
  const slots = document.getElementById("slots");

  if (!dateInput || !grid || !slots) {
    return;
  }

  const cfg = (window.cvetofor && window.cvetofor.config && window.cvetofor.config.flatpickr) || {};

  const DAY_NAMES = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
  const WEEKDAYS = ["пн", "вт", "ср", "чт", "пт", "сб", "вс"];
  const MONTHS = [
    "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
  ];
  const MONTHS_GEN = [
    "января", "февраля", "марта", "апреля", "мая", "июня",
    "июля", "августа", "сентября", "октября", "ноября", "декабря"
  ];

  const parseDMY = function (str) {
    const parts = String(str || "").split(".").map(Number);
    if (parts.length !== 3 || parts.some(isNaN)) {
      return null;
    }
    return new Date(parts[2], parts[1] - 1, parts[0]);
  };

  const startOfDay = function (date) {
    const copy = new Date(date);
    copy.setHours(0, 0, 0, 0);
    return copy;
  };

  const pad2 = function (n) {
    return String(n).padStart(2, "0");
  };

  // Чипы рендерит сервер прямо в HTML: даже если конфиг-скрипт не доехал
  // (кэш страницы, ошибка выше по странице) — даты в них остаются верными
  const chipInputs = Array.prototype.slice.call(document.querySelectorAll(".daychip__input"));
  const chipDate = function (input) {
    return parseDMY(input ? input.value : "");
  };
  const todayChip = chipInputs.find(function (input) {
    const title = document.querySelector('label[for="' + input.id + '"] .daychip__title');
    return !!title && title.textContent.trim() === "Сегодня";
  });

  if (!cfg.minDate) {
    console.warn("delivery config missing — calendar anchored to chips");
  }

  const minDate = startOfDay(parseDMY(cfg.minDate) || chipDate(chipInputs[0]) || new Date());
  // серверная «сегодня»: не зависит от часов на устройстве клиента
  const today = startOfDay(
    (cfg.minDateTimeStamp ? new Date(cfg.minDateTimeStamp) : null) ||
    chipDate(todayChip) ||
    parseDMY(cfg.minDate) ||
    new Date()
  );

  const formatDMY = function (date) {
    return pad2(date.getDate()) + "." + pad2(date.getMonth() + 1) + "." + date.getFullYear();
  };

  const keyYMD = function (date) {
    return date.getFullYear() + "-" + pad2(date.getMonth() + 1) + "-" + pad2(date.getDate());
  };

  let selected = null;               // выбранная дата
  let shown = new Date(minDate);     // отображаемый месяц (любой день внутри)

  // Выбор источника интервалов — как в observer старого дизайна:
  // точные даты → сегодня → обычный день недели
  const intervalsFor = function (date) {
    const byDate = (cfg.dates || {})[keyYMD(date)];
    if (byDate && byDate.length) {
      return byDate;
    }

    if (startOfDay(date).getTime() === today.getTime()) {
      const todayTimes = cfg.todayTimes || [];
      if (todayTimes.length) {
        return todayTimes;
      }
    }

    return (cfg.times || {})[DAY_NAMES[date.getDay()]] || [];
  };

  const renderSlots = function (date) {
    const intervals = intervalsFor(date);

    slots.innerHTML = "";

    if (!intervals.length) {
      const li = document.createElement("li");
      li.className = "slots__empty";
      li.textContent = "На эту дату нет интервалов";
      slots.appendChild(li);
      return;
    }

    intervals.forEach(function (interval, i) {
      const value = interval[0] + (interval[1] ? " - " + interval[1] : "");
      const id = "slot-" + (i + 1);

      const li = document.createElement("li");

      const input = document.createElement("input");
      input.className = "slot__input visually-hidden";
      input.type = "radio";
      input.name = "delivery_time";
      input.id = id;
      input.value = value;
      // первый интервал не отмечаем: время выбирает пользователь,
      // «Далее» без выбора блокирует проверка шага 2

      const label = document.createElement("label");
      label.className = "slot";
      label.htmlFor = id;
      label.append(value);

      const mark = document.createElement("span");
      mark.className = "slot__mark";
      mark.setAttribute("aria-hidden", "true");
      label.appendChild(mark);

      li.appendChild(input);
      li.appendChild(label);
      slots.appendChild(li);
    });
  };

  const syncChips = function (date) {
    chipInputs.forEach(function (input) {
      input.checked = !!date && input.value === formatDMY(date);
    });
  };

  // выбор интервала тоже гасит предупреждение «выберите дату и время»
  slots.addEventListener("change", function () {
    const deliveryError = document.querySelector("[data-delivery-error]");
    if (deliveryError) {
      deliveryError.hidden = true;
    }

    updateDeliveryPrice();
  });

  // Пересчёт стоимости доставки — аналог calcDelivery старого дизайна:
  // POST на deliveryRadius с выбранным интервалом. Координаты не передаём —
  // город фиксированный, проверка радиуса в контроллере работает только
  // при наличии координат. При изменении цены — всплывашка #delivery-summ
  const updateDeliveryPrice = function () {
    const routes = window.cvetofor && window.cvetofor.config && window.cvetofor.config.routes;
    if (!routes || !routes.deliveryRadius) {
      return;
    }

    const tracker = document.querySelector("[data-delivery-price-current]");
    const slot = slots.querySelector('input[name="delivery_time"]:checked');

    // Пересчёт доставки по координатам — как calcDelivery старого дизайна.
    // Координаты пишет блок подсказок DaData (dataset адресного поля);
    // без них сервер считает доставку по базовой цене магазина
    const addressInput = document.querySelector("[data-delivery-address]");
    const lat = addressInput ? parseFloat(addressInput.dataset.deliveryLat) : NaN;
    const lon = addressInput ? parseFloat(addressInput.dataset.deliveryLon) : NaN;

    const data = {
      delivery_time: slot ? slot.value : null
    };
    if (!isNaN(lat) && !isNaN(lon)) {
      data.coordinates = [lat, lon];
    }

    // Поля адреса видимы = режим «Я знаю адрес»: сервер сбрасывает
    // сохранённый радиус доставки (order_delivery_radius_km)
    const addressFields = document.querySelector("[data-address-fields]");
    if (addressFields && !addressFields.hidden) {
      data.isKnowAdress = true;
    }

    return request(routes.deliveryRadius.post(), "POST", data).then(function (result) {
      const response = result && result.response;
      const error = result && result.error;

      // Адрес вне зоны доставки: сервер отвечает 400 с modal=delivery-area
      if (error && error.modal === "delivery-area") {
        const text = document.querySelector("[data-delivery-area-text]");
        if (text) {
          text.textContent = error.message ||
            "По выбранному адресу доставка недоступна. Попробуйте другой адрес.";
        }
        window.Cvetofor.openOverlay("delivery-area");
        return;
      }

      if (!response) {
        return;
      }

      const money = new Intl.NumberFormat("ru-RU");

      document.querySelectorAll("[data-delivery-price]").forEach(function (el) {
        el.textContent = money.format(response.totalDeliveryPrice) + " ₽";
      });

      const total = document.querySelector("[data-total]");
      if (total) {
        total.dataset.total = response.totalPrice;
        total.textContent = money.format(response.totalPrice) + " ₽";
      }

      if (!tracker) {
        return;
      }

      const current = parseInt(tracker.value, 10);
      if (!isNaN(current) && current === response.totalDeliveryPrice) {
        return;
      }

      tracker.value = response.totalDeliveryPrice;

      const modalPrice = document.querySelector("[data-delivery-modal-price]");
      if (modalPrice) {
        modalPrice.textContent = money.format(response.totalDeliveryPrice);
      }

      const freeRow = document.querySelector("[data-delivery-modal-free]");
      const freeSum = document.querySelector("[data-delivery-modal-free-sum]");
      if (freeRow && freeSum) {
        freeRow.hidden = !(response.free > 0);
        freeSum.textContent = money.format(response.free);
      }

      window.Cvetofor.openOverlay("delivery-summ");
    }).catch(function () {
      // сеть/сервер недоступны — цены остаются серверными
    });
  };

  chipInputs.forEach(function (input) {
    input.addEventListener("change", function () {
      if (!input.checked) {
        return;
      }
      select(parseDMY(input.value));
    });
  });

  const renderGrid = function () {
    grid.innerHTML = "";

    const year = shown.getFullYear();
    const month = shown.getMonth();

    const head = document.createElement("div");
    head.className = "calendar__head";

    const prev = document.createElement("button");
    prev.type = "button";
    prev.className = "calendar__nav calendar__nav--prev";
    prev.setAttribute("aria-label", "Предыдущий месяц");
    prev.innerHTML = '<span class="chevron" aria-hidden="true"></span>';

    const title = document.createElement("span");
    title.className = "calendar__month";
    title.textContent = MONTHS[month] + " " + year;

    const next = document.createElement("button");
    next.type = "button";
    next.className = "calendar__nav";
    next.setAttribute("aria-label", "Следующий месяц");
    next.innerHTML = '<span class="chevron" aria-hidden="true"></span>';

    // за пределы min/max месяц листать нельзя
    const monthIndex = function (date) {
      return date.getFullYear() * 12 + date.getMonth();
    };
    // За границу минимума месяц не листается; вверх — без ограничений
    prev.disabled = monthIndex(new Date(year, month - 1, 1)) < monthIndex(minDate);

    head.appendChild(prev);
    head.appendChild(title);
    head.appendChild(next);
    grid.appendChild(head);

    prev.addEventListener("click", function () {
      shown = new Date(year, month - 1, 1);
      renderGrid();
    });
    next.addEventListener("click", function () {
      shown = new Date(year, month + 1, 1);
      renderGrid();
    });

    const week = document.createElement("div");
    week.className = "calendar__week";
    WEEKDAYS.forEach(function (weekday) {
      const cell = document.createElement("span");
      cell.className = "calendar__weekday";
      cell.textContent = weekday;
      week.appendChild(cell);
    });
    grid.appendChild(week);

    const days = document.createElement("div");
    days.className = "calendar__days";

    // Минимум с защитой от невалидной даты: мусорный minDate не должен
    // замыкать весь календарь — в этом случае дни не блокируем вовсе.
    // Максимума нет: любая дата из будущего доступна
    const minTime = isNaN(minDate.getTime()) ? null : minDate.getTime();

    const offset = (new Date(year, month, 1).getDay() + 6) % 7; // пн = 0
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < offset; i++) {
      const pad = document.createElement("span");
      pad.className = "calendar__day calendar__day--empty";
      days.appendChild(pad);
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const date = new Date(year, month, day);
      const time = startOfDay(date).getTime();

      const cell = document.createElement("button");
      cell.type = "button";
      cell.className = "calendar__day";
      cell.textContent = String(day);

      if (minTime !== null && time < minTime) {
        cell.disabled = true;
      }
      if (time === today.getTime()) {
        cell.classList.add("calendar__day--today");
      }
      if (selected && time === selected.getTime()) {
        cell.setAttribute("aria-pressed", "true");
      }

      cell.addEventListener("click", function () {
        select(date);
      });
      days.appendChild(cell);
    }

    grid.appendChild(days);
  };

  // подпись «Выбрать дату» заменяется на выбранную дату
  const syncToggle = function () {
    if (!details || !selected || isNaN(selected.getTime())) {
      return;
    }
    const toggle = details.querySelector(".pick-date__toggle");
    if (!toggle) {
      return;
    }

    toggle.childNodes.forEach(function (node) {
      if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
        node.textContent = " " + selected.getDate() + " " + MONTHS_GEN[selected.getMonth()] + " ";
      }
    });
  };

  const select = function (date) {
    if (!date || isNaN(date.getTime())) {
      return;
    }

    selected = startOfDay(date);
    dateInput.value = formatDMY(selected);
    syncToggle();
    syncChips(selected);
    renderSlots(selected);
    renderGrid();

    const deliveryError = document.querySelector('[data-delivery-error]');
    if (deliveryError) {
      deliveryError.hidden = true;
    }

    if (details) {
      details.open = false;
    }

    updateDeliveryPrice();
  };

  calendarWrap.classList.add("is-enhanced");
  renderGrid();

  // Адресный блок (события поля адреса и «знаю/не знаю адрес») запускает
  // тот же пересчёт — как calcDelivery старого дизайна
  window.Cvetofor = Object.assign(window.Cvetofor || {},
    { updateDeliveryPrice: updateDeliveryPrice });
});

// Чекаут, шаг 3: промокод и бонусы UDS. Перенос логики старого дизайна
// (order.blade.php) без jQuery: проверка кода UDS, списание/копление
// баллов, отмена списания и применение промокода. Серверные контракты —
// UDSController и PromocodeController: JSON {success, ...}, CSRF в request()
document.addEventListener("DOMContentLoaded", function () {
  const udsSection = document.querySelector(".bonus");
  const couponSection = document.querySelector(".coupon");
  if (!udsSection && !couponSection) return;

  const money = new Intl.NumberFormat("ru-RU");
  const totalEl = document.querySelector("[data-total]");

  const getTotal = function () {
    return totalEl ? parseFloat(totalEl.dataset.total) || 0 : 0;
  };

  // Текущая стоимость доставки: hidden-трекер в сводке (при отсутствии — 0)
  const deliveryValue = function () {
    const tracker = document.querySelector("[data-delivery-price-current]");
    return tracker ? parseFloat(tracker.value) || 0 : 0;
  };

  const setDelivery = function (price) {
    if (price === undefined || price === null) return;
    document.querySelectorAll("[data-delivery-price]").forEach(function (el) {
      el.textContent = money.format(price) + " ₽";
    });
    const tracker = document.querySelector("[data-delivery-price-current]");
    if (tracker) tracker.value = price;
  };

  // «Итого»: зачёркнутая старая сумма → новая, data-total — новая
  const renderTotal = function (oldTotal, newTotal) {
    if (!totalEl) return;
    totalEl.dataset.total = newTotal;
    totalEl.textContent = "";
    if (oldTotal !== undefined && oldTotal !== newTotal) {
      const oldSum = document.createElement("s");
      oldSum.className = "totals__sum-old";
      oldSum.textContent = money.format(oldTotal) + " ₽";
      totalEl.append(oldSum, " ");
    }
    totalEl.append(document.createTextNode(money.format(newTotal) + " ₽"));
  };

  const renderTotalPlain = function (total) {
    if (totalEl) {
      totalEl.dataset.total = total;
      totalEl.textContent = money.format(total) + " ₽";
    }
  };

  // Сообщение под полем: пустое скрыто, успех зелёным, ошибка красным
  const setResult = function (el, text, ok) {
    if (!el) return;
    el.textContent = text || "";
    el.classList.toggle("is-ok", Boolean(ok));
    el.classList.toggle("is-error", ok === false);
    el.hidden = !text;
  };

  // Кнопка в состоянии «занято»: подпись меняется, клики блокируются
  const busy = function (button, busyText, fn) {
    const label = button.textContent;
    button.disabled = true;
    button.textContent = busyText;
    return Promise.resolve()
      .then(fn)
      .catch(function (e) {
        // send() ловит сетевые ошибки сам: сюда попадают только неожиданные
        console.warn("checkout promo/uds:", e);
      })
      .finally(function () {
        button.disabled = false;
        button.textContent = label;
      });
  };

  const send = function (url, payload) {
    return request(url, "POST", payload).then(function (result) {
      return result.response || result.error || { success: false };
    }).catch(function () {
      return { success: false, message: "Ошибка соединения с сервером" };
    });
  };

  /* --- UDS --- */

  const udsInput = document.getElementById("uds");
  const udsResult = document.querySelector("[data-uds-result]");
  const udsEntry = udsSection ? udsSection.querySelector("[data-uds-entry]") : null;
  const resultBox = document.getElementById("bonus-result");
  const appliedBox = udsSection
    ? udsSection.querySelector("[data-uds-applied]")
    : null;

  // «Баллы списаны»: плашка с суммами до/после и кнопкой отмены
  const showApplied = function (points, oldTotal, newTotal) {
    if (!appliedBox) return;
    const pointsEl = appliedBox.querySelector("[data-uds-applied-points]");
    if (pointsEl) pointsEl.textContent = points;

    const total = appliedBox.querySelector("[data-uds-applied-total]");
    if (total) {
      total.textContent = "";
      total.append(document.createTextNode("Итого: "));
      const oldSum = document.createElement("s");
      oldSum.className = "bonus__total-old";
      oldSum.textContent = money.format(oldTotal) + " ₽";
      total.append(oldSum, " → ");
      const newSum = document.createElement("b");
      newSum.className = "bonus__total-new";
      newSum.textContent = money.format(newTotal) + " ₽";
      total.append(newSum);
      total.hidden = false;
    }

    appliedBox.hidden = false;
  };

  const checkBtn = udsSection ? udsSection.querySelector("[data-uds-check]") : null;
  if (checkBtn) {
    checkBtn.addEventListener("click", function () {
      busy(checkBtn, "Проверяем...", async function () {
        setResult(udsResult, "");
        const promo = udsInput ? udsInput.value.trim() : "";

        const data = await send("/uds/check", {
          uds_promo: promo,
          total: getTotal()
        });

        if (data.success) {
          const points = data.points > 0 ? data.points : 0;
          if (resultBox) {
            const pointsEl = resultBox.querySelector("[data-uds-points]");
            if (pointsEl) pointsEl.textContent = points;
            const spend = resultBox.querySelector("[data-uds-spend]");
            // списать нечего — предлагаем только копить
            if (spend) spend.hidden = !(points > 0);
            resultBox.dataset.promo = promo;
            resultBox.dataset.points = points;
            resultBox.hidden = false;
          }
          // код UDS выбран — промокод больше недоступен (несовместимы)
          setPromoVisible(false);
        } else {
          setResult(udsResult, data.message || "Ошибка проверки", false);
        }
      });
    });
  }

  const spendBtn = resultBox ? resultBox.querySelector("[data-uds-spend]") : null;
  if (spendBtn) {
    spendBtn.addEventListener("click", function () {
      busy(spendBtn, "Списываем...", async function () {
        const data = await send("/uds/create", {
          uds_promo: resultBox.dataset.promo,
          delivery: deliveryValue(),
          points: Number(resultBox.dataset.points) || 0,
          old_total: getTotal()
        });

        if (data.success) {
          setDelivery(data.delivery);
          showApplied(data.points, data.oldTotal, data.newTotal);
          renderTotal(data.oldTotal, data.newTotal);
          // баллы списаны — промокод больше недоступен (несовместимы)
          setPromoVisible(false);
          if (udsEntry) udsEntry.hidden = true;
          resultBox.hidden = true;
          setResult(udsResult, data.message || "Баллы будут списаны после оплаты.", true);
        } else {
          setResult(udsResult, data.message || "Ошибка списания", false);
        }
      });
    });
  }

  const hoardBtn = resultBox ? resultBox.querySelector("[data-uds-hoard]") : null;
  if (hoardBtn) {
    hoardBtn.addEventListener("click", function () {
      busy(hoardBtn, "Отправляем...", async function () {
        const data = await send("/uds/reward", {
          uds_promo: resultBox.dataset.promo
        });

        if (data.success) {
          setResult(udsResult, data.message || "Бонусы будут начислены после оплаты.", true);
        } else {
          setResult(udsResult, data.message || "Ошибка накопления", false);
        }
      });
    });
  }

  const resetBtn = appliedBox ? appliedBox.querySelector("[data-uds-reset]") : null;
  if (resetBtn) {
    resetBtn.addEventListener("click", function () {
      busy(resetBtn, "Отмена...", async function () {
        const data = await send("/uds/reset", {});

        if (data.success) {
          renderTotalPlain(data.total);
          appliedBox.hidden = true;
          if (resultBox) resultBox.hidden = true;
          if (udsEntry) udsEntry.hidden = false;
          if (udsInput) udsInput.value = "";
          setResult(udsResult, "");
          // списание отменено — промокод снова доступен, если не применён
          if (!promoApplied) setPromoVisible(true);
        } else {
          setResult(udsResult, data.message || "Ошибка соединения с сервером", false);
        }
      });
    });
  }

  /* --- Промокод --- */

  const promoInput = document.getElementById("promo");
  const promoResult = document.querySelector("[data-promo-result]");
  const promoBtn = couponSection ? couponSection.querySelector("[data-promo-check]") : null;

  // Промокод и UDS несовместимы: пока UDS выбран или применён, секция
  // промокода скрыта целиком (заголовок + поле). Обратимо отменой списания
  let promoApplied = false;
  const setPromoVisible = function (visible) {
    if (couponSection) couponSection.hidden = !visible;
  };

  if (promoBtn) {
    promoBtn.addEventListener("click", function () {
      busy(promoBtn, "Проверяем...", async function () {
        setResult(promoResult, "");

        const data = await send("/promocode/check", {
          promocode: promoInput ? promoInput.value.trim() : "",
          delivery: deliveryValue(),
          total: getTotal()
        });

        if (data.success) {
          setResult(promoResult, data.message || "Промокод применен", true);
          renderTotal(data.oldTotal, data.newTotal);
          setDelivery(data.delivery);
          // промокод применён: секцию UDS прячем целиком, с заголовком —
          // своё сообщение остаётся под заголовком «Промокод»
          promoApplied = true;
          if (udsSection) udsSection.hidden = true;
        } else {
          setResult(promoResult, data.message || "Ошибка проверки", false);
        }
      });
    });
  }
});

// Чекаут: пересчёт доставки по событиям адреса — пара к блоку календаря
// доставки. Те же запросы deliveryRadius, что при смене даты/интервала,
// но от поля адреса и переключателей «знаю/не знаю адрес» (аналог
// calcDelivery старого дизайна). Координаты готовит блок подсказок DaData
document.addEventListener("DOMContentLoaded", function () {
  const addressInput = document.querySelector("[data-delivery-address]");
  if (!addressInput) return;

  const recalc = function () {
    const update = window.Cvetofor && window.Cvetofor.updateDeliveryPrice;
    if (update) update();
  };

  // Адрес выбран подсказкой или геокодом blur — координаты уже в dataset
  addressInput.addEventListener("change", recalc);

  // «Я знаю адрес»: пересчёт уйдёт с isKnowAdress — поля к этому моменту
  // уже видимы (их показывает обработчик из блока «Не знаю адрес»,
  // он подписан раньше по файлу)
  const known = document.querySelector("[data-address-known]");
  if (known) {
    known.addEventListener("click", recalc);
  }

  // «Принимаю» в предупреждении без адреса: координаты неактуальны,
  // пересчёт без них — как calcDelivery({}) старого дизайна
  const accept = document.querySelector("[data-accept-no-address]");
  if (accept) {
    accept.addEventListener("click", function () {
      delete addressInput.dataset.deliveryLat;
      delete addressInput.dataset.deliveryLon;
      recalc();
    });
  }
});

// Шапка (ПК): клик по лупе раскрывает поиск на всю строку — форма
// вместо навигации/телефона, кнопка-лупа превращается в крестик.
// Крестик (та же кнопка) и Esc сворачивают обратно. Отправка —
// обычный GET /search нативным сабмитом
document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".header");
  if (!header) return;

  const toggle = header.querySelector(".header__search");
  const form = header.querySelector(".header__search-form");
  if (!toggle || !form) return;

  const input = form.querySelector("input");

  const setOpen = function (state) {
    header.classList.toggle("header--search-open", state);
    toggle.setAttribute("aria-label", state ? "Закрыть поиск" : "Поиск по каталогу");
    if (state) {
      input.focus();
    } else {
      input.blur();
    }
  };

  toggle.addEventListener("click", function (event) {
    event.preventDefault();
    setOpen(!header.classList.contains("header--search-open"));
  });

  // Пустой запрос не отправляем: поле подсвечивается красным,
  // подсветка снимается первым же вводом
  form.addEventListener("submit", function (event) {
    if (!input.value.trim()) {
      event.preventDefault();
      form.classList.add("header__search-form--error");
      input.focus();
    }
  });

  input.addEventListener("input", function () {
    form.classList.remove("header__search-form--error");
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && header.classList.contains("header--search-open")) {
      setOpen(false);
    }
  });
});

/* ==========================================================================
   Окна авторизации: вход / регистрация / восстановление пароля
   ========================================================================== */

/*
 * Перенос модалок старого дизайна (components/modals.blade.php) на те же
 * роуты бэкенда: GET /profile/authenticate, POST /register,
 * POST /profile/resetPassword. Роут входа принимает только GET, поэтому
 * запрос уходит GET — как и в старой форме. Редирект после входа ведёт
 * на /profile, редирект «назад» — телефон или пароль не сошлись.
 */
document.addEventListener("DOMContentLoaded", function () {
  const loginOverlay = document.getElementById("login");
  if (!loginOverlay) return;

  // Ошибки валидации сервера (422, {errors: {поле: [тексты]}}) — подписями
  // под полями общим механизмом: снятие по вводу работает из коробки
  const applyErrors = function (form, errors) {
    Object.keys(errors).forEach(function (name) {
      const field = form.querySelector('[name="' + name + '"]');
      if (field) window.Cvetofor.setFieldError(field, errors[name][0]);
    });
  };

  const showNote = function (form, text, ok) {
    const note = form.querySelector("[data-auth-result]");
    if (!note) return;
    note.hidden = false;
    note.className = "auth-modal__note " + (ok ? "is-ok" : "is-error");
    note.textContent = text;
  };

  const resetNote = function (form) {
    const note = form.querySelector("[data-auth-result]");
    if (!note) return;
    note.hidden = true;
    note.className = "auth-modal__note";
    note.textContent = "";
  };

  const withBusySubmit = function (form, send) {
    const submit = form.querySelector(".auth-modal__submit");
    submit.setAttribute("disabled", "disabled");
    Promise.resolve(send()).finally(function () {
      submit.removeAttribute("disabled");
    });
  };

  // Вход. fetch, а не request(): нужен конечный URL после редиректа —
  // по нему отличаем успех от неверного телефона/пароля
  const loginForm = loginOverlay.querySelector("form");
  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();

    withBusySubmit(loginForm, async function () {
      const query = new URLSearchParams(new FormData(loginForm)).toString();
      const response = await fetch(loginForm.action + "?" + query, {
        headers: {
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest"
        }
      });

      if (response.status === 422) {
        const data = await response.json();
        applyErrors(loginForm, data.errors || {});
        return;
      }

      if (new URL(response.url).pathname.replace(/\/+$/, "") === "/profile") {
        window.location.assign(response.url);
        return;
      }

      // Бэкенд при неудаче редиректит назад с пустым error bag — текст
      // ошибки знает только клиент
      window.Cvetofor.setFieldError(
        loginForm.querySelector('[name="password"]'),
        "Неверный телефон или пароль"
      );
    });
  });

  // Регистрация: пароль не вводится — сервер генерирует его и шлёт СМС-кой,
  // пользователь сразу залогинен. Ок — перезагружаем страницу
  const registerForm = document.getElementById("registration").querySelector("form");
  registerForm.addEventListener("submit", function (event) {
    event.preventDefault();
    resetNote(registerForm);

    withBusySubmit(registerForm, async function () {
      const payload = { phone: registerForm.querySelector('[name="phone"]').value };
      const exclusive = registerForm.querySelector('[name="concent_exclusive_email"]');
      if (exclusive && exclusive.checked) payload.concent_exclusive_email = "on";

      const { response, error } = await request(registerForm.action, "POST", payload);

      if (!error) {
        window.location.reload();
        return;
      }

      if (error.errors) {
        applyErrors(registerForm, error.errors);
      } else {
        showNote(registerForm, error.message || "Не удалось зарегистрироваться. Попробуйте ещё раз.", false);
      }
    });
  });

  // Восстановление: новый пароль уходит СМС-кой, сервер на любой телефон
  // отвечает успехом
  const recoveryForm = document.getElementById("password-recovery").querySelector("form");
  recoveryForm.addEventListener("submit", function (event) {
    event.preventDefault();
    resetNote(recoveryForm);

    withBusySubmit(recoveryForm, async function () {
      const { error } = await request(recoveryForm.action, "POST", {
        phone: recoveryForm.querySelector('[name="phone"]').value
      });

      if (error) {
        showNote(recoveryForm, error.message || "Не удалось отправить пароль. Попробуйте ещё раз.", false);
        return;
      }

      showNote(recoveryForm, "Новый пароль отправляем вам в СМС сообщении.", true);
    });
  });
});
