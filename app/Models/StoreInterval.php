<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class StoreInterval extends Model
{
    use HasBlocks;
    use HasRelated;
    use HasRevisions;


    public $table = 'store_intervals';



    protected $fillable = [


        'store_id',
        'time_start',
        'time_end',

    ];



}
