@if(isset($paginator->items()[0]))
    <div class="products__wrap" data-category-items="category_{{ $category_id ?? $paginator->items()[0]->groupProduct->category->id }}">
        @foreach ($paginator->items() as $price)
            @include('components.product', ['price' => $price, 'paginator' => $paginator])
        @endforeach
        @if($paginator->hasMorePages())
            <a class="button button--purple--new show-more-button" data-load-more="" href="{{ $paginator->appends(request()->input())->nextPageUrl() }}">Показать еще</a>
        @endif
    </div>
@endif
