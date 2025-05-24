<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\City;
use App\Models\Region;

class RegionRepository extends ModuleRepository
{
    public function __construct(Region $model)
    {
        $this->model = $model;
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {

        // $this->updateRepeater($object, $fields, 'cities', 'City', 'city');

        parent::afterSave($object, $fields);
    }

    public function getFormFields(TwillModelContract $object): array
    {

        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'cities', 'City', 'city');

        return $fields;
    }
}
