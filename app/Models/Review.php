<?php

namespace App\Models;


use A17\Twill\Models\Model;

class Review extends Model
{
    protected $fillable = [
        'published',
        'title',
        'description',
        'additional',
        'user_id',
        'order_id',
    ];

}
