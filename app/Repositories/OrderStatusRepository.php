<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\OrderStatus;

class OrderStatusRepository extends ModuleRepository
{
    public function __construct(OrderStatus $model)
    {
        $this->model = $model;
    }
}
