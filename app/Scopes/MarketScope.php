<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MarketScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {

        if (app()->runningInConsole()) {
            return;
        }

        if(request()->is('hub/*') && auth('twill_users')->user()){
            $builder->where(
                $model->getTable() . '.market_id',
               auth()->user()->market_id
            );
        }else{
            $builder->where(
                $model->getTable() . '.market_id',
                config('market_id')
            );
        }


    }
}
