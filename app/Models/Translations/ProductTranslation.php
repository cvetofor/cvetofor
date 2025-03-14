<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\Product;

class ProductTranslation extends Model
{
    protected $baseModuleModel = Product::class;
}
