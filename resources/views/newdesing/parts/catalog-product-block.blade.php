<!-- ================================================== Products ==== -->


<section class="section container" aria-labelledby="popular-title">
    <div class="section__head">

        <a   href="{{$cat_url}}"><h2 class="section__title" id="popular-title">{{$cat_name}}</h2></a>
        <a class="section__more" href="{{$cat_url}}">
            <img src="/template/assets/icons/arrow-right-brand.svg" alt="" width="32" height="32">
            <span class="visually-hidden">Все {{mb_strtolower($cat_name)}}</span>
        </a>
    </div>

    <ul class="products" data-category-items="category_{{ $cat_id}}">
        @foreach ($paginator->items() as $price)
          @include('newdesing.parts.product_cart_catalog',['typeproduct'=>$typeproduct])
        @endforeach


    </ul>

    @if($paginator->hasMorePages())
        <div class="products__more-wrap">
            <button class="btn btn--primary products__more  show-more-button" data-load-more="" type="button" href="{{ $paginator->appends(request()->input())->nextPageUrl() }}">Показать ещё</button>
        </div>
    @endif
</section>
