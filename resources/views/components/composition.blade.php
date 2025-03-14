@inject('compositeProducts', \App\Services\CompositeProducts::class)
@php
    $blocks = $compositeProducts->get($price);
@endphp

@if ($price->groupProduct->isMono())
    @php
        $monoData = $compositeProducts->MonoFlowersData($blocks);
    @endphp

    <div class="product__composition">
        <span class="product__composition-title">Состав букета:</span>
        <ul class="product-composition__list">
            <li class="product-composition__list-item">
                <span class="product-composition__item-title">{{ $monoData[0] }}</span>
                <span class="product-composition__item-quantity">{{ $monoData[1] }}
                    шт.</span>
            </li>
        </ul>
    </div>
@else
    <div class="product__composition">
        <span class="product__composition-title">Состав букета:</span>
        <ul class="product-composition__list">
            @foreach ($blocks as $block)
                @if ($loop->index <= 5)
                    @foreach ($block as $product)
                        <li class="product-composition__list-item">
                            <span class="product-composition__item-title">{{ $product->title }}</span>
                            <span class="product-composition__item-quantity">{{ $product->count }}
                                шт.</span>
                        </li>
                    @endforeach
                @else
                ...
                @php
                    break;
                @endphp
                @endif
            @endforeach
        </ul>
    </div>
@endif
