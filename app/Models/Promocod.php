<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Model;

class Promocod extends Model
{
    use HasBlocks;

    protected $fillable = [
    'title','code','type_sale','sale','platform','date_start','date_end','total_limit','client_limit','minimal_sum_cart','type_max_sale','sum_max_sale','type_order','show_in_order','products','categories','tags','promoall'
    ];
    public $casts=['date_start'=>'date','date_end'=>'date','products'=>'array','categories'=>'array','tags'=>'array'];


  /*  public function getProductsAttribute($value)

    {
        return collect(json_decode($value))->map(function($item) {

            return ['id' => $item];

        })->all();

    }
    public function setProductsAttribute($value)

    {

        $this->attributes['products'] = collect($value)->filter()->values();

    }*/
    public function getTagsAttribute($value)

    {
        return collect(json_decode($value))->map(function($item) {

            return ['id' => $item];

        })->all();

    }
    public function setTagsAttribute($value)

    {

        $this->attributes['tags'] = collect($value)->filter()->values();

    }
    public function getTagIdsAttribute()
    {

        $value = $this->attributes['tags'] ?? '[]';

        return json_decode($value);
    }
    public function getCategoriesAttribute($value)

    {
        return collect(json_decode($value))->map(function($item) {

            return ['id' => $item];

        })->all();

    }
    public function getCategoryIdsAttribute()
    {

        $value = $this->attributes['categories'] ?? '[]';

        return json_decode($value);
    }
    public function setCategoriesAttribute($value)

    {

        $this->attributes['categories'] = collect($value)->filter()->values();

    }
    public function orders(){
        return  $this->hasMany(Order::class)->whereNull('parent_id');
    }

    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    // Средний чек
    public function getAverageOrderAmountAttribute()
    {
        return round($this->orders()->avg('total_price')) ?? 0;
    }

    // Сумма скидок
    public function getDiscountSumAttribute()
    {
        return $this->orders()->sum('promocode_points') ?? 0;
    }

}
