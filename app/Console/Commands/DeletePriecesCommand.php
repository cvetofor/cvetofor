<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\GroupProduct;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Region;
use App\Models\Remain;
use App\Repositories\CityRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class DeletePriecesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Разово обновить магазин';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GroupProduct::query()
            ->chunk(100, function ($products) {

                foreach ($products as $product) {

                    $remains = ProductPrice::query()
                        ->where('group_product_id', $product->id)
                        ->orderBy('id')
                        ->get();

                    if ($remains->isEmpty()) {
                        continue;
                    }

                    $firstValidRemain = null;

                    foreach ($remains as $remain) {

                        // market_id не совпадает — удаляем
                        if ($remain->market_id != $product->market_id) {

                            echo "Удален remain {$remain->id} - market mismatch\n";

                            $remain->delete();
                            continue;
                        }

                        // первый подходящий remains оставляем
                        if (!$firstValidRemain) {

                            $firstValidRemain = $remain;

                            echo "Оставлен первый remain {$remain->id}\n";

                            continue;
                        }

                        // остальные подходящие удаляем
                        echo "Удален дубль remain {$remain->id}\n";

                        $remain->delete();
                    }
                }
            });

        Product::query()
            ->chunk(100, function ($products) {

                foreach ($products as $product) {

                    $remains = ProductPrice::query()
                        ->where('product_id', $product->id)
                        ->orderBy('id')
                        ->get();

                    if ($remains->isEmpty()) {
                        continue;
                    }

                    $firstValidRemain = null;

                    foreach ($remains as $remain) {

                        // market_id не совпадает — удаляем
                        if ($remain->market_id != $product->market_id) {

                            echo "Удален remain {$remain->id} - market mismatch\n";

                            $remain->delete();
                            continue;
                        }

                        // первый подходящий remains оставляем
                        if (!$firstValidRemain) {

                            $firstValidRemain = $remain;

                            echo "Оставлен первый remain {$remain->id}\n";

                            continue;
                        }

                        // остальные подходящие удаляем
                        echo "Удален дубль remain {$remain->id}\n";

                        $remain->delete();
                    }
                }
            });

        ProductPrice::onlyTrashed()
            ->chunkById(1000, function ($remains) {
print '.';
                foreach ($remains as $remain) {
                    $remain->forceDelete();
                }
            });
        return Command::SUCCESS;
    }
}
