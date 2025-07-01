@extends('twill::layouts.free')

@section('content')
    <div class="stats-container">
        <a17-title-editor title="Статистика"></a17-title-editor>
        <form action="{{ route('twill.stats.index') }}" method="GET" class="stats-form">
            <div>
                <label for="start_date">Дата с</label>
                <input type="date" id="start_date" name="start_date" value="{{ $stats['start_date'] ?? '' }}" class="form-control">
            </div>
            <div>
                <label for="end_date">Дата по</label>
                <input type="date" id="end_date" name="end_date" value="{{ $stats['end_date'] ?? '' }}" class="form-control">
            </div>
            <div>
                <label for="market_id">Магазин</label>
                <select name="market_id" id="market_id" class="form-control">
                    <option value="all">Все магазины</option>
                    @foreach ($stats['markets'] as $market)
                        <option value="{{ $market->id }}" {{ ($stats['selected_market_id'] == $market->id) ? 'selected' : '' }}>
                            {{ $market->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn">Применить</button>
            </div>
            <input type="hidden" name="bouquet_search" id="bouquet_search" value="{{ request('bouquet_search', '') }}">
            <input type="hidden" name="sort_by" id="sort_by" value="{{ request('sort_by', '') }}">
            <input type="hidden" name="sort_dir" id="sort_dir" value="{{ request('sort_dir', 'desc') }}">
        </form>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Показатель</th>
                        <th>Значение</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Количество выполненных заказов</td>
                        <td>{{ $stats['total_orders'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Общая сумма продаж</td>
                        <td>{{ number_format($stats['total_revenue'] ?? 0, 2, ',', ' ') }} руб.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="bouquet-detail-title">Детализация по букетам</h3>
        <div class="table-filter" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: flex-start;">
            <input type="text" id="bouquetSearch" class="form-control" style="max-width: 200px;" placeholder="Поиск по названию..." value="{{ request('bouquet_search', '') }}">
        </div>
        <div class="table-container">
            <table class="table" id="bouquetsTable">
                <thead>
                    <tr>
                        <th>Название букета</th>
                        <th id="thQuantity" style="cursor:pointer;">
                            Продано (шт.)
                            <span id="arrowQuantity">
                                @if(request('sort_by') === 'total_quantity')
                                    {{ request('sort_dir', 'desc') === 'asc' ? '▲' : '▼' }}
                                @endif
                            </span>
                        </th>
                        <th id="thSum" style="cursor:pointer;">
                            Сумма
                            <span id="arrowSum">
                                @if(request('sort_by') === 'total_revenue')
                                    {{ request('sort_dir', 'desc') === 'asc' ? '▲' : '▼' }}
                                @endif
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stats['bouquets_stats'] as $bouquet)
                        <tr>
                            <td>{{ $bouquet['title'] }}</td>
                            <td>{{ $bouquet['total_quantity'] }}</td>
                            <td>{{ number_format($bouquet['total_revenue'], 2, ',', ' ') }} руб.</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Нет данных за выбранный период.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $stats['bouquets_stats']->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@push('extra_css')
    <style>
        .stats-container {
            max-width: 55%;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Поиск по названию
            document.getElementById('bouquetSearch').addEventListener('input', function() {
                document.getElementById('bouquet_search').value = this.value;
                document.querySelector('.stats-form').submit();
            });
            // Сортировка по количеству
            document.getElementById('thQuantity').addEventListener('click', function() {
                document.getElementById('sort_by').value = 'total_quantity';
                let dir = document.getElementById('sort_dir').value;
                document.getElementById('sort_dir').value = (dir === 'asc' ? 'desc' : 'asc');
                document.querySelector('.stats-form').submit();
            });
            // Сортировка по сумме
            document.getElementById('thSum').addEventListener('click', function() {
                document.getElementById('sort_by').value = 'total_revenue';
                let dir = document.getElementById('sort_dir').value;
                document.getElementById('sort_dir').value = (dir === 'asc' ? 'desc' : 'asc');
                document.querySelector('.stats-form').submit();
            });
        });
    </script>
@endpush