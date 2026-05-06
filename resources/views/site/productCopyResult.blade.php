@extends('twill::layouts.free')

{{-- @push('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush --}}

@section('customPageContent')
    <div class="custom-container">

        @if(!empty($result['created']))
            <div class="alert alert--success">

                @foreach($result['created'] as $item)
                    <div>
                        Товар:
                        <b>{{ $item['source_product_title'] }}</b>

                        →

                        Магазин:
                        <b>{{ $item['market_title'] }}</b>
                    </div>
                @endforeach

            </div>
        @endif
            @if(!empty($result['skipped']))
                <div class="alert alert--warning">

                    @foreach($result['skipped'] as $item)
                        <div>
                            Пропущено:
                            <b>{{ $item['source_product_title'] }}</b>
                            / {{ $item['market_title'] }}
                        </div>
                    @endforeach

                </div>
            @endif



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
