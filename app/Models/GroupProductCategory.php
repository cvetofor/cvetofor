<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasNesting;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use CwsDigital\TwillMetadata\Models\Behaviours\HasMetadata;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class GroupProductCategory extends Model implements Sortable
{
    use HasMedias, HasNesting, HasPosition, HasRevisions, HasSlug;
    use HasMetadata;
    use QueryCacheable;

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_category_limited && $model->limit_start_date && $model->limit_end_date) {
                if ($model->limit_end_date <= $model->limit_start_date) {
                    throw new \Exception('Дата окончания должна быть позже даты начала.');
                }
            }
        });
    }

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
    public $cacheTags = ['groupProductsCategories'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'groupProductsCategories_';

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    public $metadataFallbacks = [];

    public function scopeAvailable($query)
    {
        return $query->where(function ($q) {
            $today = now()->toDateString();
            $q->where('is_category_limited', false)
                ->orWhere(function ($q2) use ($today) {
                    $q2->where('limit_start_date', '<=', $today)
                        ->where('limit_end_date', '>=', $today);
                });
        });
    }

    public function isAvailable(): bool
    {
        if (! $this->is_category_limited) {
            return true; // Если ограничение не включено, категория доступна всегда
        }

        $today = now()->toDateString();

        return $this->limit_start_date <= $today && $this->limit_end_date >= $today;
    }

    protected $fillable = [
        'published',
        'title',
        'is_category_limited',
        'limit_start_date',
        'limit_end_date',
        'description',
        'position',
    ];

    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
            'flexible' => [
                [
                    'name' => 'free',
                    'ratio' => 0,
                ],
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 5,
                ],
            ],
        ],
    ];

    public $slugAttributes = [
        'title',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(GroupProduct::class, 'category_id');
    }
}
