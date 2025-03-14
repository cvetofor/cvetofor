<?php

namespace App\Services;

use App\Models\Market;

class MarketService
{
    public  static function getCurrentCityMarkets()
    {
        return Market::where('city_id', CitiesService::getCity()->id)->published()->get();
    }
}
