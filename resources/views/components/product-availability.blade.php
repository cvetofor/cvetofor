@if ($product->remains()->currentMarket()->first()->revisions ?? false && $product->remains()->currentMarket()->first()->revisions->count() > 0)
    <table class="table table-striped " style="margin-top:20px;">
        <thead>
            <tr>
                <td>Доступность</td>
                <td>ФИО</td>
                <td>Дата и время</td>
            </tr>
        </thead>
        @foreach ($product->remains()->currentMarket()->first()->revisions as $key => $revision)
            <tr>
                <td>{{ optional(json_decode($revision->payload))->published ? 'В наличии' : 'Нет в наличии' }}</td>
                <td>{{ optional($revision->user)->last_name }} {{ optional($revision->user)->name }}</td>
                <td>{{ $revision->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        @endforeach
    </table>
@else
    <table class="table table-striped " style="margin-top:20px;">
        <thead>
            <tr>
                <td>Доступность</td>
                <td>ФИО</td>
                <td>Дата и время</td>
            </tr>
        </thead>
    </table>
@endif
