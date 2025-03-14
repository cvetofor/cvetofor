<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\Seotag;

class SeotagRepository extends ModuleRepository
{

    public function __construct(Seotag $model)
    {
        $this->model = $model;
    }
}
