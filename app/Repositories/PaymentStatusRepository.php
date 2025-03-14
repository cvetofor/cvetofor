<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\PaymentStatus;

class PaymentStatusRepository extends ModuleRepository
{
    

    public function __construct(PaymentStatus $model)
    {
        $this->model = $model;
    }
}
