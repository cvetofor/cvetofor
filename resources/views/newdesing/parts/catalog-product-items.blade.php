@foreach ($paginator->items() as $price)
    @include('newdesing.parts.product_cart_catalog', ['typeproduct' => $typeproduct])
@endforeach
