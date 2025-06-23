<div class="product-detail__composition" data-mono="true">
    <span class="product-detail__composition-title">Состав
        букета:</span>
    <div class="product-detail__composition-content">

        @foreach ($compositions as $j => $block)
            @foreach ($block as $i => $product)
                @if ($product && $product->color)
                    <div class="composition-item">
                        <div class="composition-item__color" style="background: {{ $product->color->data['rgb'] }};">
                        </div>
                        <span class="composition-item__title">{{ $product->color->title }}</span>
                        <span class="composition-item__quantity"
                            data-count="product[{{ $product->id }}][{{ $j }}]">{{ $product->count }}
                            шт.,</span>
                    </div>
                @elseif($product)
                    <li class="product-composition__list-item">
                        <span class="product-composition__item-title">{{ $product->title }}</span>
                        <span class="product-composition__item-quantity"
                            data-count="product[{{ $product->id }}][{{ $j }}]">{{ $product->count }}
                            шт.</span>
                    </li>
                @endif
            @endforeach
        @endforeach
    </div>
   
</div>
