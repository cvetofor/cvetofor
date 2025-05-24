<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Attribute;

class AttributeRepository extends ModuleRepository
{
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }
}
