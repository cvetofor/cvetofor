<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductPrice;
use App\Services\CompositeProducts;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(Order $model)
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

    public function filter($query, array $scopes = []): Builder
    {
        $query = $query
            ->where('parent_id', '<>', null);

        return parent::filter($query, $scopes);
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);
        $object->load('user');

        $name = ' ';
        if (isset($object->user->last_name)) {
            $name = "{$object->user->last_name} ";
        }
        if (isset($object->user->name)) {
            $name .= "{$object->user->name} ";
        }

        if (isset($object->user->second_name)) {
            $name .= "{$object->user->second_name}";
        }
        $fields['name'] = $name;
        $fields['delivery_price'] = optional($object->delivery)->price;
        $fields['price'] = $object->total_price + $object->delivery?->price ?? 0;

        foreach ($object->cart as $key => $cartItem) {
            try {
                $productPrice = ProductPrice::find($cartItem['associatedModel']['id']);
                if ($productPrice && $productPrice->groupProduct) {
                    $fields['__unvisible'][$cartItem['associatedModel']['id']] = (new CompositeProducts)->get($productPrice, false);
                }
            } catch (\Throwable $th) {
                // throw $th;
            }
        }

        $fields['marketplace_comission'] = $object->getMarketplaceComission();

        $fields = $this->prepareBrowsers($object, $fields);

        return $fields;
    }

    private function prepareBrowsers($object, $fields)
    {
        $delivery = $object->delivery;
        if ($delivery) {
            $fields['browsers']['order_delivery'] = collect([
                [
                    'id' => $delivery->id,
                    'name' => $delivery->title,
                    'edit' => moduleRoute($object->delivery->getTable(), '', 'edit', $delivery->id),
                    'endpointType' => Delivery::class,
                ],
            ])->toArray();
        }

        $payment = $object->payment;
        if ($payment) {
            $fields['browsers']['order_payment'] = collect([
                [
                    'id' => $payment->id,
                    'name' => $payment->name,
                    // 'edit' => moduleRoute($object->payment->getTable(), '', 'edit', $payment->id),
                    'endpointType' => Payment::class,
                ],
            ])->toArray();
        }

        if ($object->parent_id === null) {
            $orders = $object->childs;

            if ($orders) {
                $fields['browsers']['orders'] = collect($orders->map(function ($e) {
                    return [
                        'id' => $e->id,
                        'name' => $e->title.'/ '.$e->market->name,
                        'edit' => moduleRoute($e->getTable(), '', 'edit', $e->id),
                        'endpointType' => Order::class,
                    ];
                }))->toArray();
            }
        }

        return $fields;
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        // Адрес доставки,
        // Текст открытки
        // Статус оплаты - только вперед
        // Статус доставки
        // Статус заказа

        $fields = parent::prepareFieldsBeforeSave($object, $fields);

        if (isset($fields['address.address'])) {
            $fields['address'] = $object->address;
            $fields['address']['address'] = $fields['address.address'];
            $fields['address'] = \Arr::only($fields['address'], ['address', 'coordinates', 'city']);
        }

        if (! \Gate::allows('is_owner')) {
            $fields = \Arr::only($fields, [

                // Repository - публичная часть и тут нельзя чтобы магазин сам менял
                // 'market_id',
                'delivery_status_id',
                'order_status_id',
                // 'payment_status_id',
                'address',
                'postcard_text',
                'market_comment',
            ]);
        } else {
            $fields = \Arr::only($fields, [
                // Repository - публичная часть и тут нельзя чтобы магазин сам менял
                'market_id',
                'delivery_status_id',
                'order_status_id',
                'payment_status_id',
                'address',
                'postcard_text',
                'market_comment',
            ]);
        }

        return $fields;
    }

    public function prepareFieldsBeforeCreate(array $fields): array
    {
        return [];
    }
}
