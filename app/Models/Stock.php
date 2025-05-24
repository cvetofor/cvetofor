<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class Stock extends Model
{
    use HasRelated, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'percent',
        'price',
        'market_id',
        'publish_start_date',
        'publish_end_date',
        'code',
        'quantity',
    ];

    protected $hidden = [
        'market_id',
    ];
}
