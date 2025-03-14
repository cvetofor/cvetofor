<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Support\Facades\Gate;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;

class PaymentRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
}
