<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Order;
use App\Models\Profile;

class ProfileRepository extends ModuleRepository
{
    public function __construct(Profile $model)
    {
        $this->model = $model;
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        $fields = $this->prepareBrowsers($object, $fields);

        return $fields;
    }

    private function prepareBrowsers($object, $fields)
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

        return $fields;
    }
}
