<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class Delivery extends Model
{
    use HasRevisions;

    protected $fillable = [
        'city_id',
        'order_id',
        'address',
        'km',
        'price',
        'title',
        'description',
    ];

    protected $casts = [
        'address' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public function getTitleAttribute()
    {
        return 'Доставка заказа №' . $this->order->parent->id;
    }

    public function scopeAtWork($query)
    {
        return $query->whereHas('order', function ($q) {
            return $q
                ->whereHas('deliveryStatus', function ($dq) {
                    return $dq->where('code', DeliveryStatus::TRANSFERRED);
                });
        });
    }

    public function scopeDelivered($query)
    {
        return $query->whereHas('order', function ($q) {
            return $q
                ->whereHas('deliveryStatus', function ($dq) {
                    return $dq->where('code', '<>', DeliveryStatus::TRANSFERRED);
                });
        });
    }
}
