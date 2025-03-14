# Цветофор.рф

## Заказы

Создаются N количество заказов

1. Заказ пользователя, имеет parent_id = null
   1. В нем находитсмя полная корзина и стоимость товаров с учетом доставки $order->total_price = price + delivery_price
2. Заказ магазина крепится к заказу пользователя по parent_id={id}
   1. Стоимость его заказа не учитывает стоимость доставки. Стоимость доставки можно получить через
      1. $order->delivery->price
3. Заказ имеет корзину {$order->cart} с учетом всех скидок, полученных пользователем

## Товары

Товары делятся на 2 категории

1. Товары (products)
2. 
3. Букеты (groupProducts)

У всех товаров есть цена закреплённая за каждым магазином

    price = | id| price| sku * у продуктов нет sku| market_id |

Дополнительные ссылки:

/hub/log-viewer - просмотр логов на бою



Перед использованием сбера необходимо установить сертификаты 

- https://docs.lanbilling.ru/38/integration/payment_systems/sberbank/
-
