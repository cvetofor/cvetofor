<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignOrderStat extends Model
{
    protected $fillable = ['order_id', 'visitor_id', 'design', 'phone'];
}
