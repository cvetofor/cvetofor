@extends('twill::layouts.free')

{{-- @push('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush --}}

@section('customPageContent')
    <div class="custom-container">

        <h1>{{ $product->title }}</h1>
        <p>Выберите магазины в которые нужно скопировать товар:</p>

<form action="" method="POST">
    @csrf
<input type="hidden" value="{{$product->id}}" name="ids[]">
            <div class="col-md-3">

                <label for="published">Магазин</label>
                @foreach($markets->where('id','!=',auth()->user()->market_id) as $market)
                    <label style="display:flex; align-items:center; gap:6px; border:1px solid #ddd; padding:8px 12px; border-radius:6px;">
                        <input type="checkbox" name="market_ids[]" value="{{ $market->id }}">
                        {{ $market->city?->city ?? 'Без города' }} — {{ $market->name }}
                    </label>
                @endforeach
            </div>
    <div class="row" style="margin-top: 15px">
        <button type="submit" id="actionButton" class="btn">Подтвердить</button>
    </div>
</form>



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
