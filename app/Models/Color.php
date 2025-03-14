<?php

namespace App\Models;

use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Behaviors\HasPosition;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model implements Sortable
{
    use HasPosition;
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
    public $cacheTags = ['colors'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'colors_';

    /**
    * Invalidate the cache automatically
    * upon update in the database.
    *
    * @var bool
    */
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'title',
        'published',
        'position',
        'data',
    ];

    protected $hidden = ['data',];

    protected $casts = [
        'data' => 'array'
    ];
}
