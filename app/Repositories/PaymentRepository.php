<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Payment;

class PaymentRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
}
