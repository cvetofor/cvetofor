| № | Изображение | Наименование товара | Количество| Цена | Сумма|
|:---|:---:|:---:|:---:|:---:|---:|
        @foreach ($order['cart'] as $cartItem)
            @php
                #  учитываем возможную скидку на товар
                $conditionals = \array_sum(array_values($cartItem['conditions']));
                $price = \App\Models\ProductPrice::find(isset($cartItem['associatedModel']) ? $cartItem['associatedModel']['id'] : false);

                if ($price && $price->groupProduct && isset($price->groupProduct->images('cover')[0])) {
                    $image = $price->groupProduct->images('cover')[0];
                } elseif ($price && $price->product && isset($price->product->images('preview')[0])) {
                    $image = $price->product->images('preview')[0];
                }
                else {
                    $image = '#';
                }
            @endphp
|{{ $loop->index + 1 }}|![]({{ $image }})|{{ $cartItem['name'] }}|{{ $cartItem['quantity'] }}|{{ $cartItem['price'] - $conditionals }}|{{ $cartItem['quantity'] * ($cartItem['price'] - $conditionals) }}|
        @endforeach
||||||***Доставка:*** |
|||||| {{ number_format($deliveryPrice, 2, ',', ' ') }}|
||||||***Всего:*** |
|||||| {{ number_format($order->total_price, 2, ',', ' ') }}|
