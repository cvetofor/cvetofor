<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Balance;
use App\Models\Market;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class BalanceRepository extends ModuleRepository
{
    public function __construct(Balance $model)
    {
        $this->model = $model;
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        $fields = parent::prepareFieldsBeforeSave($object, $fields);

        $fields = \Arr::only(
            $fields,
            [
                'description',
                'status',
            ]
        );

        return $fields;
    }

    public function filter($query, array $scopes = []): Builder
    {
        if (! \Gate::allows('is_owner')) {
            $query = $query->whereIn('market_id', auth()->user()->getMarketIds());
        } else {
            $query = $query->where('deleted_at', null);
        }

        return parent::filter(
            $query,
            $scopes
        );
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        $fields = $this->prepareBrowsers($object, $fields);

        return $fields;
    }

    public function prepareBrowsers($object, $fields)
    {

        $orders = $object->orders;

        if ($orders) {
            $fields['browsers']['orders'] = collect($orders->map(function ($e) {
                return [
                    'id' => $e->id,
                    'name' => $e->title,
                    'edit' => moduleRoute($e->getTable(), '', 'edit', $e->id),
                    'endpointType' => Order::class,
                ];
            }))->toArray();
        }

        $market = $object->market;

        if ($market) {
            $fields['browsers']['market'][] = [
                'id' => $market->id,
                'name' => $market->name,
                'edit' => moduleRoute($market->getTable(), '', 'edit', $market->id),
                'endpointType' => Market::class,
            ];
        }

        return $fields;
    }
}
