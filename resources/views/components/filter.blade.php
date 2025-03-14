@php
    $isOrderTitleAsc = request()->input('order.title') === 'asc';
    $isOrderPriceDesc = request()->input('order.price') === 'desc';

@endphp

<div class="section product-filters">
    <div class="container">
        <div class="product-filters__wrap">
            <div class="product-filter product-filter--price">
                <span class="product-filter__title">Цена:</span>
                <div class="product-filter__content">
                    <form class="form invalid" method="GET" action="{{ request()->fullUrlWithQuery([]) }}" data-validate-form="" data-form-body="">

                        {{-- Он нужен, иначе отвалится поиск --}}
                        @if (request()->input('q'))
                            <input type="hidden" name="q" value="{{ request()->input('q') }}">
                        @elseif(request()->input('product'))
                            <input type="hidden" name="product" value="{{ request()->input('product') }}">
                        @endif



                        <div class="fields">
                            <div class="inputholder form__inputholder">
                                <input class="inputholder__input" value="{{ request()->input('price.from') }}" type="text" name="price[from]"
                                    placeholder="1500" data-form-group="data-form-group" data-mask-number="10" />
                            </div>
                            <span class="divider">-</span>
                            <div class="inputholder form__inputholder">
                                <input class="inputholder__input" value="{{ request()->input('price.to') }}" type="text" name="price[to]" placeholder="3500"
                                    data-form-group="data-form-group" data-mask-number="10" />
                            </div>
                            <span class="unit">р.</span>
                        </div>
                        <div class="form__buttonholder" data-form-trigger="">
                            <button class="form__button button button--pink apply-btn" type="submit" disabled="" data-form-button="">
                                <span>Применить</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="product-filter product-filter--sort">
                <span class="product-filter__title">Сортировка:</span>
                <div class="product-filter__content">
                    <a class="product-sort {{ $isOrderTitleAsc ? 'product-sort--up' : 'product-sort--down' }}  {{ request()->input('order.title') ? 'active' : '' }} "
                        href="{{ request()->fullUrlWithQuery(['order' => ['title' => $isOrderTitleAsc ? 'desc' : 'asc']]) }}">
                        <span class="product-sort__title">По
                            названию</span>
                        <svg class="product-sort__icon">
                            <use href="#icon-sort">

                            </use>
                        </svg>
                    </a>
                    <a class="product-sort {{  $isOrderPriceDesc ? 'product-sort--up' : 'product-sort--down' }}  {{ request()->input('order.price') || ! request()->input('order.title') ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['order' => ['price' => $isOrderPriceDesc ? 'asc' : 'desc']]) }}">
                        <span class="product-sort__title">По цене</span>
                        <svg class="product-sort__icon">
                            <use href="#icon-sort">

                            </use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
