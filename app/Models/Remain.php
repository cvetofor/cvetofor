<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Remain extends Model
{
    use HasRevisions;
    use QueryCacheable;

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|\DateTime
     */
    public $cacheFor = 3600;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    public $cacheTags = ['remains'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'remains_';

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'quantity',
        'product_id',
        'market_id',
        'published',
        'group_product_id',
    ];

    protected $hidden =
        [
            'product_id',
            'group_product_id',
        ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute()
    {
        return $this->groupProduct->priceObj()->currentMarketGroupProductPrice($this->market_id)->first()->price ?? '';
    }

    public function groupProduct(): BelongsTo
    {
        return $this->belongsTo(GroupProduct::class);
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function scopeCurrentMarket($query): Builder
    {
        return $query->whereMarketId(auth()->guard('twill_users')->user()?->getMarketId());
    }
}
