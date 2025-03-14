<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\Form;

class FormRepository extends ModuleRepository
{
    

    public function __construct(Form $model)
    {
        $this->model = $model;
    }
}
