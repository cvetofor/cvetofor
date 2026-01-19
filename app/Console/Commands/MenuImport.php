<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\MenuFlover;
use App\Models\MenuPrice;
use App\Models\Region;
use App\Repositories\CityRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MenuImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт меню после переделки';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $array = [
            1 => 'Роза России/Кении',
            2 => 'Роза Эквадор',
            3 => 'Хризантема',
            4 => 'Эустома',
            5 => 'Диантус',
            6 => 'Альстромерия',

        ];
        foreach ($array as $key => $value) {
            $menufl = new MenuFlover();
            $menufl->title = $value;
            $menufl->sort = $key;
            $menufl->save();

        }

        $p = new MenuPrice();
        $p->price_start = 0;
        $p->price_end = 1000;
        $p->save();
        $p = new MenuPrice();
        $p->price_start = 1000;
        $p->price_end = 1500;
        $p->save();
        $p = new MenuPrice();
        $p->price_start = 1500;
        $p->price_end = 2000;
        $p->save();

        $p = new MenuPrice();
        $p->price_start = 2000;
        $p->price_end = 2500;
        $p->save();
        $p = new MenuPrice();
        $p->price_start = 2500;
        $p->price_end = 3000;
        $p->save();
        $p = new MenuPrice();
        $p->price_start = 3000;
        $p->price_end = 5000;
        $p->save();
        $p = new MenuPrice();
        $p->price_start = 5000;

        $p->save();





    }
}
