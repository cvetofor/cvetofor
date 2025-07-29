<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Repositories\RemainRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Product extends Model {
    use HasMedias, HasRelated, HasRevisions, HasSlug;
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
    public $cacheTags = ['products', 'remains'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'products_';

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected static function boot() {
        parent::boot();

        static::retrieved(function ($model) {
        });
    }

    public $mediasParams = [
        'preview' => [
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
        ],
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
        ],
    ];

    protected $fillable = [
        'published',
        'position',
        'title',
        'description',
        'verified_at',
        'is_market_public',
        'parent_id',
        'category_id',
        'market_id',
    ];

    protected $hidden = [
        'market_id',
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'is_market_public' => 'boolean',
        'price' => 'float',
    ];

    public function remains(): HasMany {
        return $this->hasMany(Remain::class, 'product_id');
    }

    public function colors() {
        return $this->getRelated('colors');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function prices(): HasMany {
        return $this->hasMany(ProductPrice::class);
    }

    public function skus(): HasMany {
        return $this->hasMany(Product::class, 'parent_id');
    }

    public function parent(): BelongsTo {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    // public function attributes(): HasMany
    // {
    //     return $this->hasMany(Attribute::class, 'product_id');
    // }

    public function scopeDraft($query): Builder {
        return $query->whereHas('remains', function ($q) {
            $q->where('published', false)->where('market_id', auth('twill_users')->user()->getMarketId());
        });
    }

    public function scopeInStock($query): Builder {
        return $query->whereHas('remains', function ($q) {
            $q->where('published', true)->where('market_id', auth('twill_users')->user()->getMarketId());
        });
    }

    public function scopeWaitToCheckAdmin($query): Builder {
        $query = $query->where('verified_at', null);

        if (! auth()->user()->can('is_owner')) {
            $query = $query->whereIn('market_id', auth()->user()->getMarketIds());
        }

        return $query;
    }

    public function scopePublished($query): Builder {
        return $query->whereHas('remains', function ($q) {
            $q->where('published', true);
        });
    }

    public function getPublishedAttribute() {
        if (auth()->guard('twill_users')->check()) {
            return $this->remains()->whereMarketIdAndProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first()->published ?? false;
        }

        return $this->attributes['published'];
    }

    public function setPublishedAttribute($value) {
        if (! isset($this->attributes['published'])) {
            $this->attributes['published'] = $value;
        }

        if (! app()->runningInConsole()) {

            if (auth()->guard('twill_users')->user()->getMarketId()) {
                $model = $this->remains()->whereMarketIdAndProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first();

                if ($model) {
                    $repository = new RemainRepository($model);
                    $repository->update($model->id, ['published' => $value]);
                }
            }
        } else {
            $this->attributes['published'] = $value;
        }
    }

    public function getPriceAttribute() {
        $user = auth()->guard('twill_users')->user();
        if (!$user) {
            return null;
        }
        $marketId = $user->getMarketId();
        $priceObj = $this->prices()->where('market_id', $marketId)->where('quantity_from', 1)->first();
        return $priceObj ? $priceObj->price : null;
    }
}
