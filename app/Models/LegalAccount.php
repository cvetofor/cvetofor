<?php

namespace App\Models;


use A17\Twill\Models\Model;

class LegalAccount extends Model
{


    protected $fillable = [
        'title',
        'recipient',
        'recipient_account',
        'bik',
        'bank',
        'correspondent_account',
        'inn',
        'kpp',
        'address',
        'order_id',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
