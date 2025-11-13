<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Promocod;

class PromocodRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Promocod $model)
    {
        $this->model = $model;
    }
}
