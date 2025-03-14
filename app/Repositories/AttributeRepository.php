<?php

namespace App\Repositories;

use App\Models\Attribute;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleJsonRepeaters;

class AttributeRepository extends ModuleRepository
{
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }
}
