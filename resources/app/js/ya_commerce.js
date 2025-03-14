window.dataLayer = window.dataLayer || [];

// Просмотр списка товаров

if ($('div.product').length) {

    let p_sheet = [];

    $("div.product").each(function (index) {

        pid = $(this).find('a.product__image-wrap').attr('href').split('/').slice(-1);
        title = $(this).find('a.product__title').text().replace(/"/g, '');
        let price = $(this).find('span.product__price').text().replace(/р./g, '').replace(/ /g, '');

        p_sheet.push({ id: pid[0], name: title, price: price });

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

    p_sheet = { id: pid[0], name: title, price: price };
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
    p_sheet = { id: pid[0], name: title, price: price, category: category };
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
    p_sheet = { id: pid, name: title, price: price };
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

    p_sheet = { id: pid, name: title, price: price, category: category };
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
    p_sheet = { id: pid[0], name: title, price: price };
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

if (location.href.indexOf("/order") > 0) {

    $("button.submit-button").on("click", function () {
        let p_sheet = [];
        //	alert();

        $("div.cart__summary-item").each(function (index) {

            pid = index + 1;
            title = $(this).find('span').eq(0).text().replace(/"/g, '');
            let price = $(this).find('span').eq(1).text().replace(/р./g, '').replace(/ /g, '');

            p_sheet.push({ id: pid, name: title, price: price });

        });
        console.log(p_sheet);
        var oid = new Date() / 1000;





        window.dataLayer.push({
            "ecommerce": {
                "currencyCode": "RUB",
                "purchase": {
                    "actionField": {
                        "id": oid
                    },
                    "products": p_sheet
                }
            }
        });




    });

}