<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\MenuFlover;
use App\Models\MenuPrice;
use App\Models\Promocod;
use App\Models\PromocodList;

class MenuFloverRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(MenuFlover $model)
    {
        $this->model = $model;
    }

}
