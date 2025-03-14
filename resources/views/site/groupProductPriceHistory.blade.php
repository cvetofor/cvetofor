@extends('twill::layouts.free')

@section('customPageContent')
    <div class="custom-container">
        <h1>{{ $groupProduct->title }}</h1>

        <table class="table">
            <thead>
                <tr>
                    <td>Стоимость</td>
                    <td>Пользователь</td>
                    <td>Дата</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($revisions as $revision)
                    @if (isset(optional(json_decode($revision->payload))
                    ->price))
                        <tr>
                            <td>₽ @money(json_decode($revision->payload)->price)</td>
                            <td>{{ optional($revision->user)->last_name }} {{ optional($revision->user)->name }}</td>
                            <td>{{ $revision->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @elseif(isset(optional(json_decode($revision->payload))
                    ->is_custom_price))
                        <tr>
                            <td>@if(optional(json_decode($revision->payload))
                                ->is_custom_price) Установлена пользовательская цена товара @else Пользовательская цена отменена @endif
                            </td>
                            <td>{{ optional($revision->user)->last_name }} {{ optional($revision->user)->name }}</td>
                            <td>{{ $revision->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

        </table>
    </div>
@stop

@push('extra_css')
    <style type="text/css">
        .custom-container {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 2px 1px 5px gray;
        }

        .custom-container>h1 {
            display: block;
            font-size: 2em;
            margin-top: 0.67em;
            margin-bottom: 0.67em;
            font-weight: bold;
        }

        .custom-container>h3 {
            display: block;
            font-size: 1.7em;
            margin-top: 0.67em;
            margin-bottom: 0.67em;
            font-weight: bold;
        }

        table>thead * {
            font-weight: bold;
        }

        .cover {
            background-color: white;
            padding: 30px;
        }

        table {
            overflow-y: auto;
            /* Trigger vertical scroll    */
            overflow-x: auto;
            /* Trigger vertical scroll    */
        }

        table.table {
            width: 100% !important;
        }

        .table td {
            vertical-align: middle;
            padding-top: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(128, 128, 128, 0.301);
        }

        table.table td .input {
            margin-top: -9px !important;
            padding: 0px;
            margin: 0px;
            display: flex;
            justify-content: center;
        }
    </style>
@endpush
