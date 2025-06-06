<?php

namespace App\Models\Slugs;

use A17\Twill\Models\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class GroupProductCategorySlug extends Model
{
    use QueryCacheable;

    protected $table = 'group_product_category_slugs';

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
    public $cacheTags = ['gpc_slugs'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'gpc_slugs_';
}
