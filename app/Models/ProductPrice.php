<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    use HasRevisions;

    protected $fillable = [
        'published',
        'product_id',
        'market_id',
        'price',
        'quantity_from',
        'group_product_id',
        'sku',
        'is_custom_price',
        'is_promo',
    ];

    protected $hidden = [
        'product_id',
        'group_product_id',
    ];

    protected $appends = ['public_price'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function groupProduct(): BelongsTo
    {
        return $this->belongsTo(GroupProduct::class);
    }

    public function remain()
    {
        if ($this->attributes['product_id'] > 0) {
            return $this->product->remains()->where('market_id', $this->attributes['market_id']);
        }

        return $this->groupProduct->remains()->where('market_id', $this->attributes['market_id']);
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function scopeCurrentMarketGroupProductPrice($query, $marketId = null): Builder
    {
        return $query->whereMarketId($marketId ?? auth()->guard('twill_users')->user()->getMarketId());
    }

    public function scopeCurrentMarketProductPrice($query, $marketId = null): Builder
    {
        return $query->whereMarketId($marketId ?? auth()->guard('twill_users')->user()->getMarketId());
    }

    public function scopePriceFilter($query)
    {
        $from = request()->input('price.from');
        $to = request()->input('price.to');

        if (
            ($from && is_numeric($from)) ||
            ($to && is_numeric($to))
        ) {
            /**
             * @var float
             */
            $comission = \Cache::remember(
                'comission',
                360,
                function () {
                    return \TwillAppSettings::getGroupDataForSectionAndName('resource', 'resource')->content['comission'];
                }
            );

            // В результате наценок, нужно правильно применять фильтрацию
            $diff_from = $from - (($comission / 100) * $from);
            $diff_to = $to - (($comission / 100) * $to);

            if ($from && is_numeric($from)) {
                $query->where('price', '>=', (float) $diff_from);
            }

            if ($to && is_numeric($to)) {
                $query->where('price', '<=', (float) $diff_to);
            }
        }

        return $query;
    }

    public function scopeOrderByPrice($query)
    {
        if (
            request()->input('order.price') && in_array(request()->input('order.price'), [
                'asc',
                'desc',
            ], true)
        ) {
            $query = $query->orderBy('price', strtoupper(request()->input('order.price')));
        } elseif (empty(request()->input('order.price')) && empty(request()->input('order.title'))) {
            $query = $query->orderBy('price', 'ASC');
        }

        return $query;
    }

    public function getRouteKeyName()
    {
        return 'sku';
    }

    /**
     * Получить стоимость доставки у конкретного магазина, в зависимости от стоимость букета
     */
    public function getDeliveryPriceAttribute()
    {
        return $this->market->getDeliveryPriceAttribute($this->public_price);
    }

    /**
     * комиссия ресурса
     */
    public function getMarketplaceComission()
    {
        return
            \Cache::remember(
                'comission',
                360,
                function () {
                    try {
                        return \TwillAppSettings::getGroupDataForSectionAndName('resource', 'resource')->content['comission'];
                    } catch (\Throwable $th) {
                        return 0;
                    }
                }
            ) ?? 0;
    }

    /**
     * Наценка на праздники
     */
    public function getMarketComission()
    {
        if (\App\Models\Hollyday::isHollyDays() && $this->market->holidays_percent > 0) {
            return $this->market->holidays_percent;
        }

        return 0;
    }

    /**
     * Посчитать все наценки, которые могут быть
     */
    public function extraCharge(float|int|null $price = 0): float
    {
        $comission = 0;

        $comission += $this->getMarketplaceComission();

        $comission += $this->getMarketComission();

        if ($comission) {
            $price = $price + ($price * $comission / 100);
        }

        return (float) $price;
    }

    /**
     * Эта цена показывается пользователям при покупке
     */
    public function getPublicPriceAttribute()
    {
        $price = $this->extraCharge($this->attributes['price']);

        // Прибавляем к цене фиксированное значение 5

        return round($price, 2);
    }

    public function getLinkAttribute()
    {
        $slug = '';
        if ($this->groupProduct->category) {
            $slug = $this->groupProduct->category->nestedSlug.'/'.$this->groupProduct->slug.'/';
        } else {
            $slug = $this->groupProduct->slug.'/';
        }

        $link = str_replace('//', '/', route('catalog.product', ['slug' => $slug, 'price' => $this->sku], false));

        return $link;
    }
}
