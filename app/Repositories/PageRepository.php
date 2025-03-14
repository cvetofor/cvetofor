<?php

namespace App\Repositories;

use App\Models\Page;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleNesting;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use CwsDigital\TwillMetadata\Repositories\Behaviours\HandleMetadata;

class PageRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleRevisions, HandleNesting, HandleMetadata, HandleSlugs;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }
}
