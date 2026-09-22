<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Store extends Model
{
    use HasBlocks;
    use HasRelated;
    use HasRevisions;


    public $table = 'stores';



    protected $fillable = [

        'title',
        'market_id',

    ];



}
