<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Promocod;
use App\Models\PromocodList;
use App\Models\Store;
use App\Models\StoreInterval;

class StoreIntervalRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(StoreInterval $model)
    {
        $this->model = $model;
    }
    public function afterSave($object, $fields): void
    {
        parent::afterSave($object, $fields);

        // Получаем значения

    }
    public function afterDelete($object):void
    {
        parent::afterDelete($object);



    }

}
