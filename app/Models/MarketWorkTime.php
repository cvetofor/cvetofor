<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MarketWorkTime extends Model
{
    use HasRevisions;

    protected $fillable = [
        'published',
        'times',
    ];

    protected $casts = [
        'times' => 'array',
    ];

    public function market(): HasOne
    {
        return $this->hasOne(Market::class, 'market_work_times_id');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Market::class, 'market_delivery_times_id');
    }

    public function getTitleAttribute()
    {
        if ($this->market->name ?? false) {
            return ($this->market->name ?? '').' / '.($this->market->city->city ?? '').': Время работы';
        }

        return ($this->delivery->name ?? '').' / '.($this->delivery->city->city ?? '').': Время доставки';
    }
}
