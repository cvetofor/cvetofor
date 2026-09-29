<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\HasMedias;
class MenuFlover extends Model
{
    use HasBlocks, HasMedias;

    protected $fillable = ['*','title','sort'  ];
    public $mediasParams = [
        'cover' => [
            'default' => [
                ['name' => 'default', 'ratio' => null], // ratio => 1 если нужен квадрат
            ],
        ],
    ];

}
