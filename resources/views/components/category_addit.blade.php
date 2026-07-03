@if(isset($paginator->items()[0]))
    <div class="products__wrap" data-category-items="category_{{ $paginator->items()[0]->product->category_id}}">
        @foreach ($paginator->items() as $price)

            @include('additional_prod_item', ['product'=>$price->product])
        @endforeach
        @if($paginator->hasMorePages())
            <a class="button button--purple--new show-more-button" data-load-more=""
               href="{{ $paginator->appends(request()->input())->nextPageUrl() }}&type=ad">Показать еще</a>
        @endif
    </div>
@endif
