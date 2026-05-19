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

class AllProductToMarket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alltomarket';

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
        Product::where('id','>',0)->update(['market_id'=>1]);
        GroupProduct::where('id','>',0)->update(['market_id'=>1]);
        ProductPrice::where('id','>',0)->update(['market_id'=>1]);
        Remain::where('id','>',0)->update(['market_id'=>1]);

        return Command::SUCCESS;
    }
}
