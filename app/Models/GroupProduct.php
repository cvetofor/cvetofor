<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Repositories\ProductPriceRepository;
use App\Services\CatalogService;
use App\Services\CitiesService;
use CwsDigital\TwillMetadata\Models\Behaviours\HasMetadata;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Rennokki\QueryCache\Traits\QueryCacheable;

class GroupProduct extends Model {
    use HasBlocks;
    use HasFiles;
    use HasMedias;
    use HasMetadata;
    use HasRevisions;
    use HasSlug;
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
    public $cacheTags = ['groupProducts'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'groupProducts_';

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    public $metadataFallbacks = [];

    protected static function boot() {
        parent::boot();

        static::retrieved(function ($model) {
        });
    }

    protected $fillable = [
        'published',
        'title',
        'description',
        'price',
        'category_id',
        'is_custom_price',
        'created_by_market_id',
        'is_public',
        'is_promo',
    ];

    public $slugAttributes = [
        'title',
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
        ],
    ];

    public $filesParams = ['preview'];

    public function remains(): HasMany {
        return $this->hasMany(Remain::class, 'group_product_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(GroupProductCategory::class, 'category_id');
    }

    public function groupProductCategory(): BelongsTo {
        return $this->belongsTo(GroupProductCategory::class, 'category_id');
    }

    public function priceObj(): HasOne {
        return $this->hasOne(ProductPrice::class, 'group_product_id');
    }

    public function prices(): HasMany {
        return $this->hasMany(ProductPrice::class, 'group_product_id');
    }

    public function currentMarketPriceObj(): HasOne {
        return $this->hasOne(ProductPrice::class, 'group_product_id')->whereMarketIdAndGroupProductId(auth('twill_users')->user()->getMarketId(), $this->id);
    }

    public function getPriceAttribute() {
        return $this->priceObj ? $this->priceObj->whereMarketIdAndGroupProductId(auth('twill_users')->user()->getMarketId(), $this->id)->first()->price ?? '' : null;
    }

    public function getPublicPriceAttribute() {
        return $this->priceObj ? $this->priceObj->whereMarketIdAndGroupProductId(auth('twill_users')->user()->getMarketId(), $this->id)->first()->public_price ?? '' : null;
    }

    public function setPriceAttribute($value) {

        if (! app()->runningInConsole()) {

            if (auth()->guard('twill_users')->user()->getMarketId()) {
                $model = $this->priceObj()->whereMarketIdAndGroupProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first();
                if ($model) {
                    $repository = new ProductPriceRepository($model);
                    $repository->update($model->id, ['price' => $value]);
                }
            }
        }
    }

    public function getIsCustomPriceAttribute() {
        return $this->priceObj()->whereMarketIdAndGroupProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first()->is_custom_price;
    }

    public function setIsCustomPriceAttribute($value) {
        if (! app()->runningInConsole()) {

            if (auth()->guard('twill_users')->user()->getMarketId()) {
                $model = $this->priceObj()->whereMarketIdAndGroupProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first();
                if ($model) {
                    $repository = new ProductPriceRepository($model);
                    $repository->update($model->id, ['is_custom_price' => $value]);
                }
            }
        }
    }

    public function getPublishedAttribute() {
        if (auth()->guard('twill_users')->check()) {
            return $this->remains()->whereMarketIdAndGroupProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first()->published ?? false;
        }

        return $this->attributes['published'];
    }

    public function setPublishedAttribute($value) {
        if (! isset($this->attributes['published'])) {
            $this->attributes['published'] = $value;
        }

        if (! app()->runningInConsole()) {

            if (auth()->guard('twill_users')->user()->getMarketId()) {
                $model = $this->remains()->whereMarketIdAndGroupProductId(auth()->guard('twill_users')->user()->getMarketId(), $this->id)->first();

                if ($model) {
                    $model->published = $value;
                    $model->save();
                }
            }
        } else {
            $this->attributes['published'] = $value;
        }
    }

    /**
     * Монобукет, все товары одинаковы
     * Бывают товары которые не показываются пользователю - их нельзя учитывать.
     *
     * @return bool
     */
    public function isMono() {
        $blocks = $this->blocks()->select('content->browsers->products as product')->where('type', 'products')->get();

        $blocks = $blocks->pluck('product');

        $flipped = array_flip($blocks->toArray());

        if (count($flipped) !== 1) {
            foreach ($flipped as $id => $key) {
                $arr = json_decode($id);
                if (optional(Product::published()->whereIn('id', $arr)->first())->category) {
                    $isVisible = Product::published()->whereIn('id', $arr)->first()->category->is_visible;
                } else {
                    $isVisible = true;
                }

                if (! $isVisible) {
                    unset($flipped[$id]);
                }
            }
        }

        $isMono = count($flipped) === 1 && count($flipped) >= 1;

        return $isMono;
    }

    /**
     * Является акционным товаром
     *
     * @return bool
     */
    public function getIsPromoAttribute() {
        return $this->currentMarketPriceObj->is_promo ?? false;
    }

    /**
     * Является акционным товаром
     *
     * @return bool
     */
    public function setIsPromoAttribute(bool $value) {
        // $this->currentMarketPriceObj->is_promo = $value;
        // $this->currentMarketPriceObj->save();
    }

    // /////////////-SCOPES-///////////////

    public function scopeDraft($query): Builder {
        return $query
            ->whereHas(
                'remains',
                function ($q) {
                    $q->where('published', false)->where('market_id', auth('twill_users')->user()->getMarketId());
                }
            );
    }

    public function scopeSearch($query): Builder {
        if (request()->has('filter')) {
            $json = json_decode(request()->get('filter'), true);

            if (isset($json['search']) && $json['search']) {

                if (CatalogService::isSku($json['search'])) {
                    $query->whereHas('prices', function ($q) use ($json) {

                        if (! \Gate::allows('is_owner')) {
                            $q->where('market_id', auth('twill_users')->user()->getMarketId());
                        }

                        return $q->where('sku', $json['search']);
                    });
                } else {
                    $query->where('title', 'ilike', '%' . $json['search'] . '%');
                }
            }
        }

        return $query;
    }

    /**
     * Для фильтрации товаров созданных магазином в админке
     *
     * @return void
     */
    public function scopeCurrentMarket($query): Builder {
        return $query->where('created_by_market_id', auth('twill_users')->user()->getMarketId());
    }

    /**
     * Для фильтрации товаров созданных маркетплейсом
     *
     * @return void
     */
    public function scopeCommon($query): Builder {
        return $query->where('is_public', true)->where('created_by_market_id', '<>', auth('twill_users')->user()->getMarketId());
    }

    /**
     * Всех магазинов принадлежащих директору
     *
     * @return void
     */
    public function scopeAllGroupPoruductBelongsMarket($query): Builder {
        return $query
            // убираем текущий магазин
            // ->where('created_by_market_id', '<>', auth('twill_users')->user()->getMarketId())

            // оставляем другие магазины
            ->whereIn('created_by_market_id', auth('twill_users')->user()->getMarketIds());
    }

    /**
     * Всех магазинов принадлежащих директору
     *
     * @return void
     */
    public function scopeAll($query): Builder {
        return $query
            ->whereIn('created_by_market_id', auth('twill_users')->user()->getMarketIds())
            ->common();
    }

    public function scopePublished($query): Builder {
        return $query->whereHas('priceObj', function ($q) {
            $q->where('market_id', auth('twill_users')->user()->getMarketId());
        })
            ->whereHas('remains', function ($q) {
                $q->where('published', true)->where('market_id', auth('twill_users')->user()->getMarketId());
            });
    }

    public function scopeInStock($query): Builder {
        return $query
            ->whereHas(
                'remains',
                function ($q) {
                    $q->where('published', true)->where('market_id', auth('twill_users')->user()->getMarketId());
                }
            );
    }

    public function scopeCurrentCity($query) {
        return $query->with(['priceObj'])->whereHas('priceObj', function ($qp) {
            return $qp->whereHas('market', function ($qm) {
                return $qm->where('city_id', CitiesService::getCity()->id);
            });
        });
    }
}
