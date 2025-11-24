<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class PromocodList extends Model
{
    use HasBlocks;

    public $fillable=['*','code','promocod_id'];


}
