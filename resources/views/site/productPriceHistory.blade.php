@extends('twill::layouts.free')

{{-- @push('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush --}}

@section('customPageContent')
    <div class="custom-container">

        <h1>{{ $product->title }}</h1>

        @include('components.product-availability', [
            'product' => $product,
        ])

        @foreach ($skus as $sku)
            <h3>{{ $sku->getRelated('colors')->first()->title ?? '' }}</h3>
            @include('components.product-availability', [
                'product' => $sku,
            ])
        @endforeach

        <a17-custom-tabs :tabs="{{ json_encode($tabs) }}">

            @foreach ($prices as $key => $price)
                <div class="custom-tab custom-tab--quantity_{{ (int) $price->quantity_from }}">
                    <table class="table table-striped ">
                        @if ($price->revisions)
                            @foreach ($price->revisions as $key => $revision)
                                <tr>
                                    <td>₽ @money(optional(json_decode($revision->payload))->price) </td>
                                    <td>{{ optional($revision->user)->last_name }}
                                        {{ optional($revision->user)->name }}</td>
                                    <td>{{ $revision->created_at->format('d.m.Y H:i (МСК)') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- <tr>
                            <td colspan="3">График</td>
                        </tr>
                        <tr>
                            <td colspan="3"><canvas id="price-{{ $price->id }}"></canvas></td>
                        </tr> --}}
                    </table>
                </div>

                {{-- @push('extra_js')
                    <script>
                        const ctx{{ $price->id }} = document.getElementById('price-{{ $price->id }}');

                        new Chart(ctx{{ $price->id }}, {
                            type: 'line',
                            data: {
                                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                datasets: [{
                                    label: '# График изменений',
                                    data: [12, 19, 3, 5, 2, 3],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                @endpush --}}
            @endforeach
        </a17-custom-tabs>
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
