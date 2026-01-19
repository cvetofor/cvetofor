<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class MenuPrice extends Model
{
    use HasBlocks;

    protected $fillable = ['*','price_start','price_end','sort'  ];



}
