@if(isset($paginator->items()[0]))
    <div class="products__wrap" data-category-items="category_{{ $paginator->items()[0]->product->category_id}}">
    @foreach ($paginator->items() as $price)

        @include('additional_prod_item', ['product'=>$price->product])
    @endforeach
    </div>
@endif
