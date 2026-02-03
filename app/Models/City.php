<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class City extends Model
{
    use HasPosition;
    use HasRelated;
    use HasSlug;
  //  use QueryCacheable;

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|\DateTime
     */
    public $cacheFor = 0;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    public $cacheTags = ['cities'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'cities_';

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'published',
        'position',
        'address',
        'postal_code',
        'country',
        'federal_district',
        'region_type',
        'region',
        'area_type',
        'area',
        'city_type',
        'city',
        'settlement_type',
        'settlement',
        'kladr_id',
        'fias_id',
        'fias_level',
        'capital_marker',
        'okato',
        'oktmo',
        'tax_office',
        'timezone',
        'geo_lat',
        'geo_lon',
        'population',
        'foundation_year',
        'region_id',
    ];

    public $slugAttributes = [
        'city',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function markets(): HasMany
    {
        return $this->hasMany(Market::class, 'city_id');
    }

    public function scopeActive($query): Builder
    {

        return $query
            ->where('published', true)
            ->has('markets')
            ->whereHas('markets', function ($q) {
                return $q->published()->whereHas('prices', function ($qp) {
                    return $qp->whereHas('groupProduct', function ($qg) {
                        return $qg->where('price', '<>', null)->where('price', '<>', 0);
                    });
                });
            });
    }

    /**
     * Падеж для городов в баннере
     *
     * @return void
     */
    public function getParentCaseAttribute()
    {
        $city = $this->city;

        if ($city) {
            $ch = mb_substr($city, -1);

            $replace = [
                'к', 'н', 'г', 'ш', 'щ', 'з', 'х',
                'ф', 'в', 'п', 'р', 'л', 'д', 'ж',
                'ч', 'м', 'т', 'б',
            ];

            if (in_array($ch, $replace)) {
                $city .= 'е';
            } elseif (in_array($ch, ['а', 'й'])) {
                $city = rtrim($city, $ch);
                $city .= 'е';
            }

        }

        return $city;
    }
}
