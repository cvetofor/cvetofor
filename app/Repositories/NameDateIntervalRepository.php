<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\DateInterval;
use App\Models\MenuFlover;
use App\Models\MenuPrice;
use App\Models\NameDateInterval;
use App\Models\Promocod;
use App\Models\PromocodList;

class NameDateIntervalRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(NameDateInterval $model)
    {
        $this->model = $model;
    }

    public function afterDelete($object):void
    {
        parent::afterDelete($object);


        DateInterval::where('name_date_interval_id', $object->id)->delete();
    }
}
