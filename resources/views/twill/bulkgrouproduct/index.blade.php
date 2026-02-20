@extends('twill::layouts.free')


@section('content')

    <div class="stats-container" style="max-width: 95%">


        <a17-title-editor title="Массовое редактирование букетов"></a17-title-editor>


        <form action="{{ route('twill.bulkgrouproduct.index') }}" method="GET" class="stats-form">
            <div class="row">
                <div class="row">
                    <div class="col-md-3">

                        <label for="published">Наличие</label>
                        <select name="published" id="published" class="form-control">
                            <option>Все</option>
                            <option value="1" @if(request('published')==1) selected @endif>В наличии</option>
                            <option value="0" @if(request('published')==0) selected @endif>Не в наличии</option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="trash">Удаленные</label>
                        <select name="trash" id="trash" class="form-control">
                            <option value="1">Не удаленные</option>
                            <option value="2" @if(request('trash')==2) selected @endif>В корзине</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="category_id">Категории </label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option>Все</option>
                            @foreach ($cats as $market)
                                <option
                                    value="{{ $market->id }}" {{ (request('category_id') == ''.$market->id) ? 'selected' : '' }}>
                                    {{ $market->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tag_id">Теги </label>
                        <select name="tag_id" id="tag_id" class="form-control">
                            <option>Все</option>
                            @foreach ($tags as $market)
                                <option
                                    value="{{ $market->id }}" {{ (request('tag_id') == $market->id) ? 'selected' : '' }}>
                                    {{ $market->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-3">
                        <input type="text" name="name" id="name" class="form-control" style="max-width: 200px;"
                               placeholder="Поиск по названию..." value="{{ request('name', '') }}"></div>
                    <div class="col-md-3">
                        <input type="text" name="price_from" id="price_from" class="form-control"
                               style="max-width: 200px;"
                               placeholder="Цена от" value="{{ request('price_from', '') }}"></div>
                    <div class="col-md-3">
                        <input type="text" name="price_to" id="price_to" class="form-control" style="max-width: 200px;"
                               placeholder="Цена до" value="{{ request('price_to', '') }}"></div>
                    <div class="col-md-3">
                        <input type="text" name="flover" id="flover" class="form-control" style="max-width: 200px;"
                               placeholder="Цветок" value="{{ request('flover', '') }}"></div>


                </div>

            </div>
            <div class="row">
                <button type="submit" class="btn">Поиск</button>
            </div>

        </form>
        <hr>
        <h3 class="bouquet-detail-title">Действия</h3>
        <form action="/hub/bulkgrouproduct/doit" id="actionForm" method="POST">
            @csrf
            <div class="row">

                <div сlass="col-md-3">
                    <label for="doit">Выбрать действие</label>
                    <select name="doit" id="doit" class="form-control">
                        <option value="">Выбрать</option>
                        <option value="delete">Удалить</option>
                        <option value="publish">Опубликовать</option>
                        <option value="unpublish">Снять с публикации</option>
                        <option value="site">Публичный букет ВКЛ</option>
                        <option value="unsite">Публичный букет ВЫКЛ</option>
                        <option value="setcat">Назначить категорию</option>
                        <option value="addtag">Добавить повод</option>
                        <option value="deletetag">Удалить повод</option>
                        <option value="calcprice">Рассчитать цену</option>
                        <option value="setprice">Установить цену</option>

                    </select>
                </div>
            </div>
            <!-- Категория -->
            <div class="row hiddenx" id="categoryBlock">
                <div class="col-md-3">
                    <label>Категория</label>
                    <select name="category_id" id="actionCategory" class="form-control">
                        <option value="">Выбрать категорию</option>
                        @foreach($cats as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Теги -->
            <div class="row hiddenx" id="tagBlock">
                <div class="col-md-3">
                    <label>Повод</label>
                    <select name="tag_id" id="actionTag" class="form-control">
                        <option value="">Выбрать повод</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row hiddenx" id="priceBlock">
                <div class="col-md-3">
                    <label>Цена</label>
                    <input class="form-control" style="max-width: 200px;"
                name="price" value="">
                </div>
            </div>
            <div class="row" style="margin-top: 15px">
                <button type="button" id="actionButton" class="btn">Подтвердить</button>
            </div>


            <h3 class="bouquet-detail-title">Букеты</h3>

            <div class="table-container">
                <table class="table" id="bouquetsTable">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th style="max-width: 40px">Изоб.</th>
                        <th style="max-width: 40px">Доступ.</th>
                        <th>Название букета</th>
                        <th>Стоимость</th>
                        <th>Стоимость на сайте</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products  as $product)
                        <tr>
                            <td><input type="checkbox" name="id[]" value="{{$product->id}}"></td>
                            <th>
                                <img
                                    src="{{$product->images('cover', 'mobile')[0]??'dist/img/image-content/error404-pic.svg'}}"
                                    style="width: 36px;
  height: 36px; border-radius: 100%">
                            </th>
                            <td> @if($product->published)
                                    <span data-v-120b42fa="" data-v-de97889a="" data-tooltip-title="Unpublish"
                                          class="tablecell__pubstate tablecell__pubstate--live"
                                          aria-describedby="tooltip--dhgz32nyy3"></span>
                                @endif</td>
                            <td>
                                <div style="display: inline-block">

                                    {{ $product->title }}
                                </div>
                            </td>
                            <td> {{ round((float) $product->price)}} руб.</td>
                            <td> {{ round((float) $product->public_price)}} руб.</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Нет данных за выбранный период.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="pagination-container">
                    {{ $products->appends(request()->all())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </form>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const checkAll = document.getElementById('checkAll');

            checkAll.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('#bouquetsTable tbody input[type="checkbox"]');

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = checkAll.checked;
                });
            });


            const actionSelect = document.getElementById('doit');
            const categoryBlock = document.getElementById('categoryBlock');
            const tagBlock = document.getElementById('tagBlock');
            const priceBlock = document.getElementById('priceBlock');

            actionSelect.addEventListener('change', function () {
                // скрываем всё
                categoryBlock.classList.add('hiddenx');
                tagBlock.classList.add('hiddenx');
                priceBlock.classList.add('hiddenx');

                if (this.value === 'setcat') {
                    categoryBlock.classList.remove('hiddenx');
                }
                if (this.value === 'setprice') {
                    priceBlock.classList.remove('hiddenx');
                }


                if (this.value === 'addtag' || this.value === 'deletetag') {
                    tagBlock.classList.remove('hiddenx');
                }
            });

            document.getElementById('actionButton').addEventListener('click', function () {
                const action = document.getElementById('doit').value;


                if (!action) {
                    alert('Пожалуйста, выберите действие! ');
                    return;
                }


                const checkboxes = document.querySelectorAll('#bouquetsTable input[type="checkbox"]:checked');
                if (checkboxes.length === 0) {
                    alert('Пожалуйста, выберите хотя бы один букет!');
                    return;
                }
                // Проверка дополнительных селектов
                if (action === 'setcat') {
                    const cat = document.getElementById('actionCategory').value;
                    if (!cat) {
                        alert('Выберите категорию!');
                        return;
                    }
                }

                if (action === 'addtag' || action === 'deletetag') {
                    const tag = document.getElementById('actionTag').value;
                    if (!tag) {
                        alert('Выберите повод!');
                        return;
                    }
                }


                const actionText = actionSelect.options[actionSelect.selectedIndex].text;

                const confirmed = confirm(`Вы уверены, что хотите выполнить действие: "${actionText}"?`);

                if (!confirmed) return;

                document.getElementById('actionForm').submit();
            });
        });


    </script>
@endsection

@push('extra_css')
    <style>
        .hiddenx {
            display: none !important;
        }

        .stats-container {
            max-width: 55%;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
        }

        .stats-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 30px;
            justify-content: center;
        }

        .table-container {
            margin-top: 20px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.5rem 1.25rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            cursor: pointer;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .stats-container .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }

        .stats-container .page-item .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            text-decoration: none;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .stats-container .page-item:hover .page-link {
            z-index: 2;
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .stats-container .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .stats-container .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            cursor: auto;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .stats-container .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem;
        }

        .stats-container .page-item:last-child .page-link {
            border-top-right-radius: .25rem;
            border-bottom-right-radius: .25rem;
        }

        .bouquet-detail-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 2.0rem;
            font-weight: bold;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px;
        }

        [class^="col-md-"] {
            padding-left: 15px;
            padding-right: 15px;
            box-sizing: border-box;
        }

        /* col-md-* */
        .col-md-1 {
            width: 8.333333%;
        }

        .col-md-2 {
            width: 16.666667%;
        }

        .col-md-3 {
            width: 25%;
        }

        .col-md-4 {
            width: 33.333333%;
        }

        .col-md-5 {
            width: 41.666667%;
        }

        .col-md-6 {
            width: 50%;
        }

        .col-md-7 {
            width: 58.333333%;
        }

        .col-md-8 {
            width: 66.666667%;
        }

        .col-md-9 {
            width: 75%;
        }

        .col-md-10 {
            width: 83.333333%;
        }

        .col-md-11 {
            width: 91.666667%;
        }

        .col-md-12 {
            width: 100%;
        }

    </style>

@endpush
