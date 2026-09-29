<section class="section section--tight container" aria-labelledby="filters-title">
    <h2 class="visually-hidden" id="filters-title">Фильтры каталога</h2>

    <form class="filters panel" action="{{ request()->fullUrlWithQuery([]) }}" method="get"
          data-filter data-target="#products">
        @if (request()->input('q'))
            <input type="hidden" name="q" value="{{ request()->input('q') }}">
        @elseif(request()->input('product'))
            <input type="hidden" name="product" value="{{ request()->input('product') }}">
        @endif
        <div class="filters__group">
            <span class="filters__label" id="price-label">Цена:</span>
            <div class="filters__range" role="group" aria-labelledby="price-label">
                <input class="field field--num" type="number" name="price[from]"
                       value="{{ request()->input('price.from')??0 }}" min="0" step="100" aria-label="Цена от, ₽" required>
                <img class="filters__dash" src="/template/assets/icons/minus.svg" alt="—" width="25"
                     height="25">
                <input class="field field--num" type="number" name="price[to]"
                       value="{{ request()->input('price.to')??3500 }}" min="0" step="100" aria-label="Цена до, ₽" required>
                <span class="filters__unit" aria-hidden="true">₽</span>
            </div>
            <button class="btn btn--primary card__buy" type="submit">Применить</button>
        </div>


            @php
            $order = request()->query('order', []);
            // ?order[price]=desc → 'price', ?order[title]=desc → 'new', иначе ничего
            $currentSort = isset($order['price']) ? 'price'
            : (isset($order['title']) ? 'new' : null);
            @endphp

            <div class="filters__group">
                <label class="filters__label" for="sort">Сортировка:</label>
                <select class="field field--select" id="sort" name="sort">
                    @if (!$currentSort)
                        <option value="" selected disabled>Выбрать</option>
                    @endif
                    <option value="price" @if($currentSort === 'price') selected @endif>По цене</option>
                    <option value="new" @if($currentSort === 'new') selected @endif>По названию</option>
                </select>
            </div>

        <button class="btn btn--primary visually-hidden" type="submit">Показать</button>

        {{--<div class="filters__view" role="group" aria-label="Вид отображения">
            <button class="view-btn is-active" type="button" aria-pressed="true">
                <img src="/template/assets/icons/view-grid.svg" alt="Плиткой" width="34" height="34">
            </button>
            <button class="view-btn" type="button" aria-pressed="false">
                <img src="/template/assets/icons/view-list.svg" alt="Списком" width="29" height="29">
            </button>
        </div>--}}
    </form>
</section>
