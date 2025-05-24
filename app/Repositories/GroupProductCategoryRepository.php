<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleNesting;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\GroupProductCategory;
use CwsDigital\TwillMetadata\Repositories\Behaviours\HandleMetadata;

class GroupProductCategoryRepository extends ModuleRepository
{
    use HandleMedias, HandleMetadata, HandleNesting, HandleRevisions, HandleSlugs;

    public function __construct(GroupProductCategory $model)
    {
        $this->model = $model;
    }
}
