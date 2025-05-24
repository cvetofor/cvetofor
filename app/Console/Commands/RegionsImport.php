<?php

namespace App\Console\Commands;

use App\Models\Region;
use App\Repositories\RegionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RegionsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regions:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт регионов из github';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // https://raw.githubusercontent.com/hflabs/region/master/region.csv
        $csv = Http::get('https://raw.githubusercontent.com/hflabs/region/master/region.csv');
        $repository = new RegionRepository(new Region);

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
            if (filled($arrs['name'])) {
                $city = $repository->firstOrCreate($arrs);
                $city->position = $i;
                $city->published = true;
                $city->save();
            }
        }

        return Command::SUCCESS;
    }
}
