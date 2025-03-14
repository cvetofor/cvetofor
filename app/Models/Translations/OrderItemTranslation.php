<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\OrderItem;

class OrderItemTranslation extends Model
{
    protected $baseModuleModel = OrderItem::class;
}
