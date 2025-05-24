<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Hollyday;

class HollydayRepository extends ModuleRepository
{
    public function __construct(Hollyday $model)
    {
        $this->model = $model;
    }
}
