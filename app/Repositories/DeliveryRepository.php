<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\ModuleRepository;
use App\Events\OrderDeliveryChanged;
use App\Models\Delivery;
use App\Models\DeliveryStatus;
use Illuminate\Database\Eloquent\Builder;

class DeliveryRepository extends ModuleRepository
{
    public function __construct(Delivery $model)
    {
        $this->model = $model;
    }

    public function hasBehavior(string $behavior): bool
    {
        if ($behavior == 'revisions') {
            return false;
        }

        return parent::hasBehavior($behavior);
    }

    public function filter(Builder $query, array $scopes = []): Builder
    {
        $query->whereHas('order', function ($q) {
            return $q
                ->where('market_id', auth('twill_users')->user()->getMarketId())
                ->where('delivery_status_id', '<>', null);
        });

        return parent::filter(
            $query,
            $scopes
        );
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);
        $deliveryStatus = $object->order->deliveryStatus;
        if ($deliveryStatus) {
            $fields['browsers']['order_deliveryStatus'] = collect([
                [
                    'id' => $deliveryStatus->id,
                    'name' => $deliveryStatus->title,
                    // 'edit' => moduleRoute($object->deliveryStatus->getTable(), '', 'edit', $deliveryStatus->id),
                    'endpointType' => DeliveryStatus::class,
                ],
            ])->toArray();
        }

        $fields['is_photo_needle'] = $object->order->is_photo_needle;
        $fields['is_anon'] = $object->order->is_anon;
        $fields['comment'] = $object->order->comment;
        $fields['person_receiving_name'] = $object->order->person_receiving_name;
        $fields['person_receiving_phone'] = $object->order->person_receiving_phone;
        $fields['address'] = $object->order->address;
        $fields['delivery_date'] = $object->order->delivery_date;
        $fields['delivery_time'] = $object->order->delivery_time;
        $fields['total_price'] = $object->price;

        return $fields;
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        // $fields =  parent::prepareFieldsBeforeSave($object, $fields);

        if (\Arr::get($fields, 'browsers.order_deliveryStatus.0.id', null)) {

            $fields['delivery_status_id'] = \Arr::get($fields, 'browsers.order_deliveryStatus.0.id', null);

            $order = app(OrderRepository::class);

            $order->update($object->order->id, [
                'delivery_status_id' => $fields['delivery_status_id'],
            ]);

            event(new OrderDeliveryChanged($object->order));
        }

        $fields = [];

        return $fields;
    }
}
