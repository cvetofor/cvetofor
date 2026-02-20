jQuery.cookie = function (name, value, options) {
  if (typeof value != 'undefined') { // name and value given, set cookie
    options = options || {};
    if (value === null) {
      value = '';
      options.expires = -1;
    }
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
      var date;
      if (typeof options.expires == 'number') {
        date = new Date();
        date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
      } else {
        date = options.expires;
      }
      expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
    }
    // CAUTION: Needed to parenthesize options.path and options.domain
    // in the following expressions, otherwise they evaluate to undefined
    // in the packed version for some reason...
    var path = options.path ? '; path=' + (options.path) : '';
    var domain = options.domain ? '; domain=' + (options.domain) : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
  } else { // only name given, get cookie
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        // Does this cookie string begin with the name we want?
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
          break;
        }
      }
    }
    return cookieValue;
  }
};


window.dataLayer = window.dataLayer || [];

// Просмотр списка товаров

if ($('div.product').length) {

  let p_sheet = [];

  $("div.product").each(function (index) {

    pid = $(this).find('a.product__image-wrap').attr('href').split('/').slice(-1);
    title = $(this).find('a.product__title').text().replace(/"/g, '');
    let price = $(this).find('span.product__price').text().replace(/р./g, '').replace(/ /g, '');

    p_sheet.push({id: pid[0], name: title, price: price});

  });
  console.log(p_sheet);
  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "impressions": p_sheet
    }
  });
}


//Клик по товару из списка

$("div.product").on("click", function () {
  let p_sheet;

  let pid = $(this).find('a.product__image-wrap').attr('href').split('/').slice(-1);
  let title = $(this).find('a.product__title').text().replace(/"/g, '');
  let price = $(this).find('span.product__price').text().replace(/р./g, '').replace(/ /g, '');

  p_sheet = {id: pid[0], name: title, price: price};
  console.log(p_sheet);
  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "click": {
        "products": [p_sheet]
      }
    }
  });


});


//Просмотр товара

if (location.href.indexOf("/catalog/") > 0) {

  let p_sheet;

  let pid = location.href.split('/').slice(-1);
  let title = $('h1.h1').text().replace(/"/g, '');
  let price = $('span.product-detail__price').text().replace(/Артикул:/g, '').replace(/ /g, '').replace(/р./g, '');
  let category = $('.breadcrumbs a').eq(-1).find('span').text();
  p_sheet = {id: pid[0], name: title, price: price, category: category};
  console.log(p_sheet);

  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "detail": {
        "products": [
          p_sheet
        ]
      }
    }
  });
}


//Добавление товара в корзину


$("button.add-product-to-cart-button").on("click", function () {

  let p_sheet;

  let pid = $(this).data('put-cart-sku');
  let title = $(this).closest('.product').find('.product__title').text().replace(/"/g, '');
  let price = $(this).closest('.product').find('.product__price').text().replace(/р./g, '').replace(/ /g, '');
  p_sheet = {id: pid, name: title, price: price};
  console.log(p_sheet);

  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "add": {
        "products": [
          p_sheet
        ]
      }
    }
  });


});


//Добавление товара в корзину из карточки товара

$("button.add-to-cart-button").on("click", function () {

  let p_sheet;

  let pid = $(this).data('sku');
  let title = $('h1.h1').text().replace(/"/g, '');
  let price = $('span.product-detail__price').text().replace(/Артикул:/g, '').replace(/ /g, '').replace(/р./g, '');
  let category = $('.breadcrumbs a').eq(-1).find('span').text();

  p_sheet = {id: pid, name: title, price: price, category: category};
  console.log(p_sheet);


  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "add": {
        "products": [
          p_sheet
        ]
      }
    }
  });
});


//Удаление товара из корзины

$("button.remove-cart-item-button").on("click", function () {

  let p_sheet;

  let pid = $(this).closest('.cart__item').find('.cart__item-image__wrap').attr('href').split('/').slice(-1);
  let title = $(this).closest('.cart__item').find('.cart__item-title').text().replace(/"/g, '');
  let price = $(this).closest('.cart__item').find('.cart__item-price').text().replace(/р./g, '').replace(/ /g, '');
  p_sheet = {id: pid[0], name: title, price: price};
  console.log(p_sheet);


  window.dataLayer.push({
    "ecommerce": {
      "currencyCode": "RUB",
      "remove": {
        "products": [
          p_sheet
        ]
      }
    }
  });
});


//Покупка

//Покупка
function by_send_order(order_id,p_sheet) {

  console.log(p_sheet);

  if ($.cookie('ya_order') == null) {

    window.dataLayer.push({
      "ecommerce": {
        "currencyCode": "RUB",
        "purchase": {
          "actionField": {
            "id": order_id
          },
          "products": p_sheet
        }
      }
    });
    $.cookie('ya_order', '1', {expires: 1, path: '/', secure: true});
  }

}
