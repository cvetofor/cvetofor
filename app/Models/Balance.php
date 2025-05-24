<?php

namespace App\Models;

use A17\Twill\Models\Model;

class Balance extends Model
{
    const STATUS = [
        'APPROVED' => 'APPROVED',
        'WAIT_APPROVE' => 'WAIT_APPROVE',
    ];

    protected $fillable = [
        'published',
        'title',
        'description',
        'total',
        'market_id',
        'status',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'balance_order');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'like', self::STATUS['APPROVED']);
    }

    public function scopeWaitApprove($query)
    {
        return $query->where('status', 'like', self::STATUS['WAIT_APPROVE']);
    }
}
