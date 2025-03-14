<?php

namespace App\Http\Requests;

use App\Models\Market;
use App\Services\Helpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class OrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            # address
            # is_photo_needle
            # is_anon
            # postcard_text

            'payment_id'             => [
                'required',
                'exists:App\Models\Payment,id',
            ],
            'person_receiving_name'  => [
                'required',
                'string',
            ],
            'person_receiving_phone' => [
                'required',
                'string',
            ],
            'delivery_date'          => [
                'required',
                'string',
            ],
            'delivery_time'          => [
                'required',
                'string',
            ],
            'fio'                    => [
                'required',
                'min:3',
            ],
            'phone'                  => [
                'required',
                'min:10',
            ],
            'comment'                => [
                'max:1000',
            ],
            'address'                => [
                'max:5000',
            ],
            'email'                  => [
                'email',
            ],
            #'postcard' => 'nullable|accepted',
        ];
    }


    public function checkRadius($markets) {
        if ($this->has('coordinates')) {
            [$lat, $long] = explode(',', $this['coordinates']);
            foreach ($markets as $market) {
                $lt = $market->city->geo_lat;
                $ln = $market->city->geo_lon;

                $deliveryRadiusKm = Helpers::haversineGreatCircleDistance(
                    $lat,
                    $long,
                    $lt,
                    $ln
                );

                session()->put('order_delivery_radius_km', $deliveryRadiusKm);

                $maxDeliveryRadius = $market->delivery_radius;


                if ($deliveryRadiusKm > $maxDeliveryRadius) {
                    return [
                        'radius'  => $deliveryRadiusKm,
                        'modal'   => 'delivery-area',
                        'message' => "Продавец {$market->name} не осуществляет доставку по выбранному адресу. Попробуйте выбрать другой адрес.",
                    ];
                }
            }
        } else {
            session()->forget('order_delivery_radius_km');
        }
        return false;
    }

    public function checkTimes($markets) {

        $userDate = new \DateTime($this['delivery_date'] . ' ' . date('h') . ':' . date('i'));

        $deliveryMinDate = Market::getDeliveryDate($markets);

        $times = Market::getDeliveryTime($markets)['times'][strtolower($userDate->format('l'))] ?? [];

        if (!in_array(explode(' - ', $this->delivery_time), $times)) {
            return true;
        }

        if ($userDate->format('d.m.Y') === $deliveryMinDate->format('d.m.Y')) {
            return false;
        }
        if ($userDate->getTimestamp() < $deliveryMinDate->getTimestamp()) {
            return true;
        }
    }
}
