<?php

namespace App\Repositories;


use App\Models\Color;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;

class ColorRepository extends ModuleRepository
{
    protected array $fieldsGroups = [
        'data' => [
            'rgb',
        ],
    ];



    # The below can be setup optionally, documented below.

    public bool $fieldsGroupsFormFieldNamesAutoPrefix = true;

    public string $fieldsGroupsFormFieldNameSeparator = '_';

    public function __construct(Color $model)
    {
        $this->model = $model;
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}
