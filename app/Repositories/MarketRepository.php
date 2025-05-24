<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Models\User;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleJsonRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\City;
use App\Models\Market;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class MarketRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleJsonRepeaters;
    use HandleRevisions;

    protected $jsonRepeaters = [
        'additional_addresses',
        'deliveries_radius',
    ];

    public function __construct(Market $model)
    {
        $this->model = $model;
    }

    protected $relatedBrowsers = [
        'user' => [
            'moduleName' => 'Users',
            'relation' => 'user',
        ],
        'city' => [
            'moduleName' => 'City',
            'relation' => 'city',
        ],
    ];

    public function filter($query, array $scopes = []): Builder
    {

        if (! \Gate::allows('is_owner')) {
            $query = $query->whereIn('id', auth()->user()->getMarketIds());
        }

        return parent::filter($query, $scopes);
    }

    public function prepareFieldsBeforeCreate($fields): array
    {
        // нельзя самостоятельно управлять балансом
        unset($fields['balance']);
        $fields = parent::prepareFieldsBeforeCreate($fields);

        Arr::set($fields, 'blocks', null);
        Arr::set($fields, 'browsers', null);

        return $fields;
    }
    // On save we set the linkable id and type.

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        unset($fields['balance']);
        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.user.0.id', null);
        if ($id) {
            $fields['user_id'] = $id;
        }

        $id = Arr::get($fields, 'browsers.city.0.id', null);
        if ($id) {
            $fields['city_id'] = $id;
        }

        Arr::set($fields, 'browsers', null);

        return $fields;
    }

    public function beforeSave(TwillModelContract $object, array $fields): void
    {
        /**
         * @var \App\Services\Market\EmployerService::class
         */
        $employersService = new \App\Services\Market\EmployerService($object);
        try {
            $data = data_get($fields, 'blocks.*.content');

            if ($data && count($data) > 10) {
                response()->json(
                    [
                        'message' => __('Не больше 10 сотрудников'),
                        'variant' => 'error',
                    ],
                    200
                )->send();
                exit();
            }

            if ($data) {
                $employersService->resolve($fields);
            } else {
                $employersService->detachAll();
            }

        } catch (\App\Exceptions\LaravelJsonException $th) {
            response()->json(json_decode($th->getMessage()), 200)->send();
            exit();
        } catch (\Illuminate\Validation\ValidationException $e) {

        }

        if (! auth()->user()->can('is_owner')) {
            Arr::set($fields, 'browsers.user', null);
            Arr::set($fields, 'browsers.work_times', null);
            Arr::set($fields, 'browsers.delivery_times', null);
        }

        Arr::set($fields, 'blocks', null);

        parent::beforeSave($object, $fields);
    }

    // Set the browser value to our morphed data.
    public function getFormFields(TwillModelContract $object): array
    {

        $fields = parent::getFormFields($object);
        $user = $object->user;

        if ($user) {
            $fields['browsers']['user'] = collect([
                [
                    'id' => $user->id,
                    'name' => $user->email,
                    'edit' => moduleRoute('users', '', 'edit', $user->id),
                    'endpointType' => User::class,
                ],
            ])->toArray();
        }

        $city = $object->city;

        if ($user && $city) {
            $fields['browsers']['city'] = collect([
                [
                    'id' => $city->id,
                    'name' => $city->city,
                    'edit' => moduleRoute($object->city->getTable(), '', 'edit', $city->id),
                    'endpointType' => City::class,
                ],
            ])->toArray();
        }

        $work_times = $object->work_times;

        if ($work_times) {
            $fields['browsers']['work_times'] = collect([
                [
                    'id' => $work_times->id,
                    'name' => $work_times->title,
                    'edit' => moduleRoute($object->work_times->getTable(), '', 'edit', $work_times->id),
                    'endpointType' => MarketWorkTime::class,
                ],
            ])->toArray();
        }

        $delivery_times = $object->delivery_times;

        if ($delivery_times) {
            $fields['browsers']['delivery_times'] = collect([
                [
                    'id' => $delivery_times->id,
                    'name' => $delivery_times->title,
                    'edit' => moduleRoute($object->delivery_times->getTable(), '', 'edit', $delivery_times->id),
                    'endpointType' => MarketWorkTime::class,
                ],
            ])->toArray();
        }

        if ($object->employees()->count() > 0) {
            $fields['blocksFields'] = $this->prepareFields($object->employees()->get());
            $fields['blocks'] = $this->prepareBlocks($object->employees()->get());
        }

        return $fields;
    }

    public function prepareFields(\Illuminate\Support\Collection $users)
    {
        return \Arr::collapse($users->transform(
            function ($e) {
                return [
                    [
                        'name' => 'blocks['.$e->id.'][role]',
                        'value' => $e->role->code ?? 'manager',
                    ],
                    [
                        'name' => 'blocks['.$e->id.'][name]',
                        'value' => $e->name,
                    ],
                    [
                        'name' => 'blocks['.$e->id.'][email]',
                        'value' => $e->email,
                    ],
                    [
                        'name' => 'blocks['.$e->id.'][phone]',
                        'value' => $e->phone,
                    ],
                    [
                        'name' => 'blocks['.$e->id.'][second_name]',
                        'value' => $e->second_name,
                    ],
                    [
                        'name' => 'blocks['.$e->id.'][last_name]',
                        'value' => $e->last_name,
                    ],
                ];
            }
        )
            ->toArray());
    }

    public function prepareBlocks(\Illuminate\Support\Collection $users)
    {
        return [
            'default' => $users->transform(
                function ($e) {
                    return [
                        'id' => $e->id,
                        'type' => 'a17-block-employers',
                        'title' => 'Сотрудник',
                        'name' => 'default',
                        'titleField' => 'name',
                        'hideTitlePrefix' => true,
                        'attributes' => [],
                        'icon' => 'add',
                    ];
                }
            )->toArray(),
        ];
    }
}
