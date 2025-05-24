<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\City;
use App\Models\Region;
use Illuminate\Support\Arr;

class CityRepository extends ModuleRepository
{
    use HandleSlugs;

    protected $relatedBrowsers = [
        'province' => [
            'moduleName' => 'regions',
            'relation' => 'province',
        ],
    ];

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    // Prepare the fields.

    public function prepareFieldsBeforeCreate($fields): array
    {

        $fields = parent::prepareFieldsBeforeCreate($fields);

        $id = Arr::get($fields, 'browsers.province.0.id', null);
        Arr::set($fields, 'browsers', null);
        if ($id) {
            $fields['region_id'] = $id;
        }

        return $fields;
    }
    // On save we set the linkable id and type.

    public function prepareFieldsBeforeSave(TwillModelContract $object, $fields): array
    {

        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.province.0.id', null);
        Arr::set($fields, 'browsers', null);
        if ($id) {
            $fields['region_id'] = $id;
        }

        return $fields;
    }

    // Set the browser value to our morphed data.
    public function getFormFields(TwillModelContract $object): array
    {

        $fields = parent::getFormFields($object);
        $province = $object->province;

        if ($province) {
            $fields['browsers']['province'] = collect([
                [
                    'id' => $province->id,
                    'name' => $province->name_with_type,
                    'edit' => moduleRoute($object->province->getTable(), '', 'edit', $province->id),
                    'endpointType' => Region::class,
                ],
            ])->toArray();
        }

        return $fields;
    }
}
