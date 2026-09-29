@if(count($menuFlovers))

    <section class="section container" id="categories">
        <div class="section__head">
            <h2 class="section__title">По категориям</h2>
           @if(!isset($not_short)) <a class="section__more section__more--chevron" href="/all-category">
                <span class="visually-hidden">Все категории</span>
            </a>@endif
        </div>

        <ul class="categories">
            @foreach (!isset($not_short)?$menuFlovers->take(7):$menuFlovers as $menuItem)
                <li class="categories__item">
                    <a class="category"
                       href="{{ route('catalog.search') }}?product={{ urlencode($menuItem->title) }}">
            <span class="category__media">
              <img src="{{$menuItem->image('cover', 'default', [], true) ?: '/template/assets/img/cat-rose.webp' }}" alt="" width="126" height="126" loading="lazy">
            </span>
                        <span class="category__name">{{$menuItem->title }}</span>
                    </a>
                </li>


            @endforeach
            @if(count($menuFlovers)>7&& !isset($not_short))
                <li class="categories__item">
                    <a class="category" href="/all-category">
            <span class="category__media category__media--all">
              <span class="dots" aria-hidden="true"><i></i><i></i><i></i></span>
            </span>
                        <span class="category__name">Все категории</span>
                    </a>
                </li>@endif


        </ul>
    </section>
@endif
