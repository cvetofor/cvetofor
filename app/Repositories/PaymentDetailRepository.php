<?php

namespace App\Repositories;

use Gate;
use A17\Twill\Models\User;
use Illuminate\Support\Arr;
use App\Models\PaymentDetail;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;

class PaymentDetailRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(PaymentDetail $model)
    {
        $this->model = $model;
    }

    protected $relatedBrowser = [
        'user' => [
            'moduleName' => 'Users',
            'related' => 'user',
        ]
    ];


    // Prepare the fields.

    public function prepareFieldsBeforeCreate($fields): array
    {

        $fields = parent::prepareFieldsBeforeCreate($fields);

        $id = Arr::get($fields, 'browsers.user.0.id', null);
        Arr::set($fields, 'browsers', null);
        if ($id) {
            $fields['user_id'] = $id;
        }

        return $fields;
    }
    // On save we set the linkable id and type.

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {

        $fields = parent::prepareFieldsBeforeSave($object, $fields);
        $id = Arr::get($fields, 'browsers.user.0.id', null);
        Arr::set($fields, 'browsers', null);
        if ($id) {
            $fields['user_id'] = $id;
        }

        return $fields;
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
                    "endpointType" => User::class,
                ],
            ])->toArray();
        }

        return $fields;
    }
}
