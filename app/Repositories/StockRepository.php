<?php

namespace App\Repositories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleRevisions;

class StockRepository extends ModuleRepository
{
    use HandleRevisions;

    protected $relatedBrowsers = ['groupProducts', 'groupProductCategories'];

    public function __construct(Stock $model)
    {
        $this->model = $model;
    }


    public function filter($query, array $scopes = []): Builder
    {

        $query = $query->where('market_id', '=', auth()->guard('twill_users')->user()->getMarketId());

        return parent::filter($query, $scopes);
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array
    {

        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $fields['market_id'] = auth()->guard('twill_users')->user()->getMarketId();

        return $fields;
    }
}
