<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\MenuPrice;
use App\Models\Promocod;
use App\Models\PromocodList;

class MenuPriceRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(MenuPrice $model)
    {
        $this->model = $model;
    }
    protected function defaultOrders()
    {
        return [
            'sort' => 'asc', // сортировка по умолчанию
        ];
    }
}
