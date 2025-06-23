<div class="product-detail__composition" data-mono="false">
    <span class="product-detail__composition-title">Состав
        букета:</span>
    <div class="product-detail__composition-content">
        @foreach ($compositions as $j => $block)
            @foreach ($block as $i => $product)
                <li class="product-composition__list-item">
                    <span class="product-composition__item-title">{{ $product->title }}</span>
                    <span class="product-composition__item-quantity"
                        data-count="product[{{ $product->id }}][{{ $j }}]">{{ $product->count }}
                        шт.</span>
                </li>
            @endforeach
        @endforeach
    </div>
</div>
