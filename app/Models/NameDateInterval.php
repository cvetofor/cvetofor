<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class NameDateInterval extends Model
{
    use HasBlocks;
    protected $fillable = ['*',
        'market_id',
        'date',

    ];




    /**
     * Связь с моделью Market.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function market()
    {
        return $this->belongsTo(Market::class);
    }
    public function intervals()
    {
        return $this->hasMany(DateInterval::class );
    }



}
