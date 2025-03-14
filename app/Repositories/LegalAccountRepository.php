<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\LegalAccount;

class LegalAccountRepository extends ModuleRepository
{
    

    public function __construct(LegalAccount $model)
    {
        $this->model = $model;
    }
}
