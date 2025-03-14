<?php

namespace App\ViewModel\CatalogController;
use A17\Twill\Models\Tag;

class MainPageTagsModel
{
    public $tag;

    public $prices;

    public function __construct(Tag $tag, array $prices)
    {
        $this->tag = $tag;
        $this->prices = $prices;
    }

}
