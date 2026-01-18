<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class MenuFlover extends Model
{
    use HasBlocks;

    protected $fillable = ['*','title','sort'  ];


}
