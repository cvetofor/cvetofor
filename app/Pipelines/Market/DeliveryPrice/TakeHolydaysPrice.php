<?php

namespace App\Pipelines\Market\DeliveryPrice;

use App\Models\Hollyday;
use App\Services\CitiesService;

class TakeHolydaysPrice
{

    public function handle($data, \Closure $next)
    {
        [$price, $market] = $data;

        $isHollyDays = Hollyday::isHollyDays();

        if ($isHollyDays) {
            return $next([$market->holidays_delivery_price, $market]);
        }


        return $next([$price, $market]);
    }
}
