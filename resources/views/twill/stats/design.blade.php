@extends('twill::layouts.free')

@section('content')
    <div class="stats-container">
        <a17-title-editor title="Статистика по дизайну"></a17-title-editor>

        <form action="{{ route('twill.designStats.index') }}" method="GET" class="stats-form1">
            <div style="display: flex;width: 700px;gap: 20px;
align-items: flex-end;
margin-bottom: 30px;
border-bottom: 1px solid #eee;
padding-bottom: 30px;
justify-content: center;">
                <div>
                    <label for="start_date">Дата с</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $stats['start_date'] ?? '' }}" class="form-control">
                </div>
                <div>
                    <label for="end_date">Дата по</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $stats['end_date'] ?? '' }}" class="form-control">
                </div>
                <div>
                    <button type="submit" class="btn">Применить</button>
                </div>
            </div>
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
                        <td>Заказов с нового дизайна</td>
                        <td>{{ $stats['new_orders'] }} на {{ number_format($stats['new_revenue'], 2, ',', ' ') }} руб.</td>
                    </tr>
                    <tr>
                        <td>Заказов со старого дизайна</td>
                        <td>{{ $stats['old_orders'] }} на {{ number_format($stats['old_revenue'], 2, ',', ' ') }} руб.</td>
                    </tr>
                    <tr>
                        <td>Всего заказов</td>
                        <td>{{ $stats['new_orders'] + $stats['old_orders'] }}</td>
                    </tr>
                    <tr>
                        <td>Переходов на старый дизайн (кнопка «Вернуться в старый дизайн»)</td>
                        <td>{{ $stats['clicks'] }} (уникальных посетителей: {{ $stats['click_visitors'] }})</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="detail-title">Заказы по дизайну</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>№ заказа</th>
                        <th>Телефон</th>
                        <th>Дизайн</th>
                        <th>ID посетителя</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $row)
                        <tr>
                            <td>{{ $row->created_at?->format('d.m.Y H:i') }}</td>
                            <td>{{ $row->num_order }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>
                                @if ($row->design === 'new')
                                    <span style="color:#0e9f4f;font-weight:600;">Новый</span>
                                @else
                                    <span style="color:#dc0978;font-weight:600;">Старый</span>
                                @endif
                            </td>
                            <td>{{ $row->visitor_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Нет заказов за выбранный период.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <h3 class="detail-title">Переходы на старый дизайн</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>ID посетителя</th>
                        <th>Дизайн до перехода</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clicks as $row)
                        <tr>
                            <td>{{ $row->created_at?->format('d.m.Y H:i') }}</td>
                            <td>{{ $row->visitor_id }}</td>
                            <td>
                                @if ($row->variant_from === 'new')
                                    Новый
                                @elseif ($row->variant_from === 'old')
                                    Старый
                                @else
                                    Без куки (сразу перешёл)
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Нет переходов за выбранный период.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $clicks->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@push('extra_css')
    <style>
        .stats-container {
            max-width: 55%;
            min-width: 720px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e0e0e0;
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
        .detail-title {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 2.0rem;
            font-weight: bold;
        }
    </style>
@endpush
