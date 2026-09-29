<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\MenuFlover;
use App\Models\MenuPrice;
use App\Models\Promocod;
use App\Models\PromocodList;
use A17\Twill\Repositories\Behaviors\HandleMedias;
class MenuFloverRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias;

    public function __construct(MenuFlover $model)
    {
        $this->model = $model;
    }

}
