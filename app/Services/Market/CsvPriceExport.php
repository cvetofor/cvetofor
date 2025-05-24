<?php

namespace App\Services\Market;

use App\Models\ProductPrice;
use avadim\FastExcelLaravel\Excel;

class CsvPriceExport
{
    private $excel;

    public function __construct()
    {
        // Create workbook...
        $this->excel = Excel::create('export-'.date('d-m-Y_h_i'));
        $this->excel->setAuthor(env('APP_NAME'));

    }

    public $header = [
        'ID',
        'Наличие Y/N',
        'Название',
        '1 Шт',
        '25 Шт',
        '51 Шт',
        '101 Шт',
    ];

    public function build($marketId)
    {
        $this->excel->sheet()->writeHeader($this->header);
        $data = [];
        ProductPrice::where('market_id', $marketId)
            ->where('group_product_id', null)
            ->whereHas('product', function ($q) use ($marketId) {
                return $q
                    ->where(
                        function ($q) {
                            return $q->where('parent_id', 0)->orWhere('parent_id', null);
                        }
                    )
                    ->where(
                        function ($q) use ($marketId) {
                            return $q->where('is_market_public', true)->orWhere('market_id', $marketId);
                        }
                    );
            })
            ->chunk(
                500,
                function ($groups) use ($marketId, &$data) {
                    foreach ($groups as $item) {

                        $remains = $item->product->remains()->where('market_id', $marketId)->first();

                        $data[$item->product->id] = isset($data[$item->product->id]) ? $data[$item->product->id] : [
                            $item->product->id,
                            (($remains->published ?? false) && $item->published) ? 'Y' : 'N',
                            $item->product->title,
                        ];

                        // 4 - индекс "1шт" получается, что 4+1
                        $data[$item->product->id][$item->quantity_from + 2] = $item->price;
                    }
                }
            );
        foreach ($data as $row) {

            $this->excel->sheet()->writeRow(array_values($row));
        }
    }

    public function send()
    {
        return $this->excel->download(auth()->user()->market->name ?? 'export-'.date('d-m-Y_h_i'));
    }
}
