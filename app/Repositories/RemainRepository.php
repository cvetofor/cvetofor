<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Remain;

class RemainRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(Remain $model)
    {
        $this->model = $model;
    }
}
