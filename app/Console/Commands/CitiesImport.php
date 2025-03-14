<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Region;
use App\Repositories\CityRepository;
use DASPRiD\Enum\Exception\IllegalArgumentException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CitiesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт городов из github';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // https://raw.githubusercontent.com/hflabs/city/master/city.csv

        $csv = Http::get('https://raw.githubusercontent.com/hflabs/city/master/city.csv');

        $repository = new CityRepository(new City);

        $csvLines = explode(PHP_EOL, $csv);
        $header = [];
        foreach ($csvLines as $i => $c) {
            $line = str_getcsv($c);

            if ($i == 0) {
                $header = $line;
                continue;
            }


            $arrs = [];
            foreach ($line as $j => $attr) {
                $arrs[$header[$j]] = $attr ?: null;
            }

            if (count($arrs) == count($header)) {

                // У Москвы нет города, только Регион
                if (!filled($arrs['city']) && $arrs['region'] === 'Москва') {
                    $arrs['city'] = $arrs['region'];
                }

                if($arrs['area_type'] === "г" && $arrs['area'] && ! $arrs['city'])
                {
                    $arrs['city'] = $arrs['area'];
                }

                $city = $repository->firstOrCreate($arrs);

                $region = Region::where('name', 'like', '%' . $city->region . '%')->first();
                if ($region) {
                    $city->region_id = $region->id;
                }

                $city->position = $i;
                $city->published = true;
                $city->save();
            }
        }

        return Command::SUCCESS;
    }
}
