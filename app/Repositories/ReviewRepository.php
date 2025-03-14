<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\Review;

class ReviewRepository extends ModuleRepository
{
    

    public function __construct(Review $model)
    {
        $this->model = $model;
    }
}
