@php
    $contentFieldsetLabel = 'Список товаров';
    $is_owner = auth()->user()->can('is_owner');
@endphp

@extends('twill::layouts.form', [
    'additionalFieldsets' => [['fieldset' => 'products', 'label' => 'Товары'], ['fieldset' => 'order_info', 'label' => 'Информация о заказе']],
])

@section('contentFields')
    @foreach ($item->cart as $cartItem)
        @php
            // dd($cartItem);
        @endphp
        <a17-fieldset id="product-{{ $cartItem['id'] }}" title='«{{ $cartItem['name'] }}» x {{ $cartItem['quantity'] }} шт'
            style="margin-top:20px" :open="true">

            @if (isset($cartItem['attributes']['composition']))
                @foreach ($cartItem['attributes']['composition'] as $composition)
                    <div class="wrapper" style="margin-top:20px">
                        <div class="col col--double">
                            {{ $composition['title'] }}
                            @if ($composition['color'])
                                <span
                                    style="margin-left:5px;display:inline-block;background: {!! $composition['rgb'] !!}; width:12px; height:12px;border: 1px solid #dbe4e7; border-radius: 50%;"></span>
                                ({{ optional(\App\Models\Color::find($composition['color']))->title }})
                            @endif
                        </div>
                        <div class="col col--double">
                            {{ $composition['count'] }} шт.
                        </div>
                    </div>
                @endforeach
            @endif

            @php
                $price = \App\Models\ProductPrice::find(
                    isset($cartItem['associatedModel']) ? $cartItem['associatedModel']['id'] : false,
                );
            @endphp

            <div class="wrapper" style="margin-top:20px">
                <div class="col col--double">
                    Артикул:
                    <span>{{ $price->sku ?? '-' }}</span>
                </div>
            </div>

            <div class="wrapper" style="margin-top:20px">
                <div class="col col--double">
                    Цена:
                    <span>{{ number_format($cartItem['price'], 2, '.', '') ?? '0.00' }} руб</span>
                </div>
            </div>

            @if ($price && $price->groupProduct)
                <details style="margin-top:20px">
                    <summary>Изображения</summary>
                    <div class="hovergallery">
                        @foreach ($price->groupProduct->images('cover') as $image)
                            @if ($loop->index <= 2)
                                <img src="{{ $image }}" />
                            @endif
                        @endforeach
                    </div>
                </details>
            @elseif($price && $price->product)
                <details style="margin-top:20px">
                    <summary>Изображения</summary>
                    <div class="hovergallery">
                        <img src="{!! $price->product->images('preview')[0] ?? '' !!}" />
                    </div>
                </details>
            @endif

        </a17-fieldset>
    @endforeach

    <a17-fieldset id="delivery" title="Доставка" style="margin-top:20px" :open="true">

        <div class="wrapper" style="margin-top:20px">
            <div class="col col--double">
                Стоимость:
                <span>{{ $item->delivery->price }} руб</span>
            </div>
        </div>

    </a17-fieldset>

@stop

@section('fieldsets')

    <a17-fieldset id="order_info" title="Информация о заказе">
        <div class="wrapper">
            <div class="col col--double">
                <x-twill::checkbox name="is_photo_needle" label="Требуется фото" :disabled="true" />
            </div>
            <div class="col col--double">
                <x-twill::checkbox name="is_anon" label="Анонимный букет" :disabled="true" />
            </div>
        </div>

        <div class="wrapper">
            <div class="col--double">
                <x-twill::input name="phone" label="Телефон" :disabled="true" />
            </div>
            <div class="col--double">
                <x-twill::input name="name" label="ФИО" :disabled="true" />
            </div>
        </div>
        {{--
    <x-twill::input name="address.coordinates" label="Координаты" /> --}}
        {{--
    <x-twill::input name="address.city" label="Город" /> --}}

        <x-twill::input name="comment" type="textarea" label="Комментарий" rows="5" :disabled="true" />
        <x-twill::input name="postcard_text" type="textarea" label="Текст открытки" rows="5" />
    </a17-fieldset>

    @if (!empty($form_fields['__unvisible']))
        <a17-fieldset id="service_goods" title="Служебные товары" :open="false">
            <p>Товары невидимые для пользователя</p>
            @foreach ($form_fields['__unvisible'] as $unvisible)
                @foreach ($unvisible as $pagination)
                    @foreach ($pagination as $product)
                        - {{ $product->title }}
                    @endforeach
                @endforeach
            @endforeach
        </a17-fieldset>
    @endif
@endsection

@section('sideFieldsets')

    <a17-fieldset id="products" title="Кому">

        @if ($item->parent?->payment_link)
            <a href="{{ $item->parent->payment_link ?: '#' }}" style="margin-top: 15px">Ссылка на оплату</a>
        @endif

        @if ($item->payment_link)
            <a href="{{ $item->payment_link ?: '#' }}" style="margin-top: 15px">Ссылка на оплату</a>
        @endif


        <x-twill::input name="person_receiving_name" label="Имя" rows="5" :disabled="true" />
        <x-twill::input name="person_receiving_phone" label="Телефон" rows="5" :disabled="true" />
        <x-twill::input name="address.address" label="Адрес доставки" />

        <x-twill::input name="address.apartament_number" label="Квартира" />

        <x-twill::date-picker name="delivery_date" label="Необходимая дата доставки" :withTime="false" :disabled="true" />
        <x-twill::input name="delivery_time" label="Интервал" :disabled="true" />

    </a17-fieldset>

    <a17-fieldset id="cost" title="Стоимость: {{ $item->total_price + $item->delivery?->price ?? 0 }} руб"
        :open="false">
        <x-twill::input name="price" type="number" prefix="₽ " label="Общая стоимость" :disabled="true" />

        @if($item->uds_points)
            <x-twill::input name="uds_points" type="number" prefix="₽ " label="Скидка UDS" :disabled="true" />
        @endif 

        @if (isset($item['meta']['basePrice']) && $item['meta']['basePrice'] > 0)
            <x-twill::input name="marketplace_comission" prefix="₽ " type="number" label="Комиссия ресурса"
                :disabled="true" />
        @endif


        <div class="wrapper">
            <div class="col--double">
                <x-twill::input name="total_price" prefix="₽ " type="number" label="Стоимость товаров"
                    :disabled="true" />
            </div>
            <div class="col--double">
                <x-twill::input name="delivery_price" prefix="₽ " type="number" label="Стоимость доставки"
                    :disabled="true" />
            </div>
        </div>
        {{--
    <x-twill::input type="number" name="__unvisible.price" label="Служебная стоимость"
        note="Товары не показанные пользователю" /> --}}
    </a17-fieldset>

    <a17-fieldset id="" title="Информация">
        <x-twill::browser name="order_payment" module-name="payments" label="Оплата" :max="1"
            :disabled="true" />

        <x-twill::browser name="order_delivery" module-name="deliveries" label="Доставка" :max="1"
            :disabled="true" />
    </a17-fieldset>

    <a17-fieldset id="" title="Статус">

        <x-twill::select name="order_status_id" label="Заказа" :options="$item->getAvailabelOrderStatuses()" />
        <x-twill::select name="delivery_status_id" label="Доставки" :options="$item->getAvailabelDeliveryStatuses()" />
        <x-twill::select name="payment_status_id" label="Оплаты" :disabled="!$is_owner" :options="$item->getAvailabelPaymentStatuses()" />

    </a17-fieldset>

    <a17-fieldset id="market_info" title="Дополнительная информация">
        <x-twill::input name="market_comment" type="textarea" label="Служебная информация по заказу" rows="5"
            note="Не видна пользователю" :max="1000" />

        @if ($item->parent_id === null)
            <x-twill::browser name="orders" module-name="orders" label="Прикрепленные заказы" />

            @if ($item->payment->code == \App\Models\Payment::ACCOUNT)
                <a style="margin-top:10px;display: block;"
                    href="{{ route('order.pdf', ['order' => $item->uuid]) }}">Cкачать
                    PDF на оплату</a>
            @endif
        @endif
    </a17-fieldset>

@endsection
