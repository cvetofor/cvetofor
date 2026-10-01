@foreach ($paginator->items() as $price)
    @include('newdesing.parts.product_cart_catalog', ['typeproduct' => $typeproduct])
@endforeach

@if($paginator->hasMorePages())
    <div class="products__more-wrap">
        <button class="btn btn--primary products__more show-more-button" data-load-more="" type="button" href="{{ $paginator->appends(($typeproduct ?? '') == 'product' ? request()->input() + ['type' => 'ad'] : request()->input())->nextPageUrl() }}">Показать ещё</button>
    </div>
@endif
