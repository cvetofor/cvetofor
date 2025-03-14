<?php

namespace App\Models;

use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasNesting;
use A17\Twill\Models\Behaviors\HasPosition;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements Sortable
{
    use HasSlug, HasMedias, HasPosition, HasNesting;
    use QueryCacheable;

    /**
    * Invalidate the cache automatically
    * upon update in the database.
    *
    * @var bool
    */
    protected static $flushCacheOnUpdate = true;


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
    public $cacheTags = ['categories'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'categories_';

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'is_visible',
        'is_visible_menu',
        'is_additional_product',
    ];

    public $slugAttributes = [
        'title',
    ];


    public function products() : HasMany
    {
        return $this->hasMany(CategoryProduct::class, 'category_id');
    }
}
