<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\DeliveryStatus;

class DeliveryStatusRepository extends ModuleRepository
{
    

    public function __construct(DeliveryStatus $model)
    {
        $this->model = $model;
    }
}
