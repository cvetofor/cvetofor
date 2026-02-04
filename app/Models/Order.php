<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;
use App\Events\OrderAmocrmUpdate;
use App\Events\OrderChangeStatus;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model {
    use HasRevisions;

    public $hidden = [
        'published',
        'uuid',
        'email',
        'is_policy_accepted',
        'cart',
        'parent_id',
        'user_id',
    ];
    protected $fillable = [
        'title',
        'uuid',
        'description',
        'payment_id',
        'payment_status_id',
        'delivery_status_id',
        'order_status_id',
        'email',
        'phone',
        'address',
        'comment',
        'is_photo_needle',
        'is_anon',
        'delivery_date',
        'delivery_time',
        'total_price',
        'delivery_price',
        'postcard_text',
        'is_policy_accepted',
        'person_receiving_name',
        'person_receiving_phone',
        'cart',
        'parent_id',
        'user_id',
        'market_id',
        'city_id',
        'is_policy_accepted',
        'market_comment',
        'meta',
        'num_order',
        'source',
        'uds_points',
        'uds_code',
        'promocod_id',
        'promocode_points'
    ];
    protected $casts = [
        'address' => 'array',
        'cart' => 'array',
        'is_photo_needle' => 'boolean',
        'is_anon' => 'boolean',
        'is_policy_accepted' => 'boolean',

        // OrderMetaCast::class,
        'meta' => 'array',
    ];

    protected static function boot() {
        static::updated(function ($order) {

            if ($order->order_status_id != $order->getOriginal('order_status_id')) {
                event(new OrderChangeStatus($order));
            }

            if ($order->payment_status_id == 2) {
                event(new OrderAmocrmUpdate($order));
            }
        });

        parent::boot();
    }

    public function getRouteKeyName() {
        return 'uuid';
    }

    public function delivery() {
        return $this->hasOne(Delivery::class, 'order_id');
    }

    /**
     * Выставленный счёт на оплату, только для Юр.лиц
     *
     * @return void
     */
    public function legalAccount() {
        return $this->hasOne(LegalAccount::class, 'order_id');
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function childs() {
        return $this->hasMany(Order::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(Order::class, 'parent_id');
    }

    public function orderStatus() {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function deliveryStatus() {
        return $this->belongsTo(DeliveryStatus::class, 'delivery_status_id');
    }

    public function paymentStatus() {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function market() {
        return $this->belongsTo(Market::class, 'market_id');
    }

    public function review() {
        return $this->hasOne(Review::class, 'order_id');
    }

    public function scopeTender($builder): Builder {
        return $builder
            ->where('market_id', null)
            ->where('parent_id', '<>', null)
            ->where('city_id', auth('twill_users')->user()->market->city->id ?? null);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeCurrentMarket($builder): Builder {

            return $builder->where('market_id', auth('twill_users')->user()->getMarketId());

    }

    /**
     * Заказы со статусом оформлен
     */
    public function scopeIssued($builder): Builder {
        return $builder
            ->currentMarket()
            ->where('market_id', '<>', null)
            ->where(function ($q) {
                $q->whereHas('orderStatus', function ($q) {
                    return $q
                        ->where('code', OrderStatus::ISSUED);
                })->orWhere('order_status_id', null);
            });
    }  public function scopePromo($builder): Builder {
        return $builder

            ->where('promocod_id',request('x_promocod_id'))
            ->where('payment_status_id',2);

    }

    /**
     * Отменен
     */
    public function scopeClosed($builder): Builder {
        return $builder
            ->currentMarket()
            ->whereHas('orderStatus', function ($q) {
                return $q
                    // Отменен магазином
                    ->where('code', 'AN')
                    // Отменен пользователем
                    ->orWhere('code', 'UN');
            });
    }

    /**
     * Заказ со статусом выполнен
     */
    public function scopeSuccesfuled($builder): Builder {
        return $builder
            ->currentMarket()
            ->whereHas('orderStatus', function ($q) {
                return $q->where('code', 'CM');
            });
    }

    /**
     * Заказ со статусом доставлен
     */
    public function scopeDeliveried($builder): Builder {
        return $builder
            ->currentMarket()
            ->whereHas('deliveryStatus', function ($q) {
                return $q->where('code', DeliveryStatus::DELIVERED);
            });
    }

    public function scopeAccepted($builder): Builder {
        return $builder
            ->currentMarket()
            ->whereHas('orderStatus', function ($q) {
                return $q->where('code', 'CO');
            });
    }

    public function getTitleAttribute() {

        if ($this->num_order) {
            $numOrder = $this->num_order;
        } elseif ($this->parent) {
            $numOrder = $this->parent->id;
        } else {
            $numOrder = $this->id;
        }

        if ($this->orderStatus?->code == OrderStatus::COMPLETE) {
            return 'Архив. Заказ №' . $numOrder;
        }

        return 'Заказ №' . $numOrder;
    }

    public function getDeliveryPriceAttribute() {
        return $this->delivery->price ?? 0.0;
    }

    public function setDeliveryPriceAttribute($value) {
    }

    public function getMarketplaceComission() {

        if (
            isset($this->meta['basePrice'])
            && $this->meta['basePrice'] > 0
            && isset($this->meta['comissions'])
        ) {
            $total = $this->total_price + $this->deliver?->price ?? 0;

            if ($this->meta['comissions']['market'] > 0) {
                $total -= ($this->meta['basePrice'] * $this->meta['comissions']['market'] / 100);
            }

            $total *= $this->meta['comissions']['marketplace'] / 100;

            return round($total);
        }

        return 0;
    }

    // ///////////////
    public function isPaymentByInvoce() {
        return $this->payment->code === 'account';
    }

    public function getAvailabelOrderStatuses() {
        return OrderStatus::published()->get()->transform(function ($e) {
            return [
                'value' => $e->id,
                'label' => $e->title,
            ];
        })->toArray();
    }

    public function getAvailabelDeliveryStatuses() {
        return DeliveryStatus::published()->get()->transform(function ($e) {
            return [
                'value' => $e->id,
                'label' => $e->title,
            ];
        })->toArray();
    }

    public function getAvailabelPaymentStatuses() {
        return PaymentStatus::published()->get()->transform(function ($e) {
            return [
                'value' => $e->id,
                'label' => $e->title,
            ];
        })->toArray();
    }
    public function promocode()
    {
        return $this->belongsTo(Promocod::class);
    }
    public function getPromocodeValueAttribute()
    {
        return $this->promocode->code ?? '';

    }
}
