<?php

namespace App\Values;

use Illuminate\Contracts\Database\Eloquent\Castable;

class OrderMeta implements Castable
{

    public $price;


    public static function castUsing(array $arguments)
    {

        return OrderMeta::class;
    }
}
