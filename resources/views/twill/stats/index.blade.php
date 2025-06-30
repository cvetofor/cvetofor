@extends('twill::layouts.free')

@section('content')
<h1>Раздел в разработке...</h1>
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
                <button type="submit" class="btn">Применить</button>
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
    </div>
@endsection

@push('extra_css')
    <style>
        .stats-container {
            max-width: 800px;
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
    </style>
@endpush