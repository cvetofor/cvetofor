<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
use Illuminate\Database\Seeder;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentStatusRepository;
use App\Repositories\DeliveryStatusRepository;

class StatusesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (PaymentStatus::count() == 0) {

            $statusesRepository = new PaymentStatusRepository(new PaymentStatus);

            $statusesRepository->create([
                'title' => 'Ожидает оплаты',
                'code' => 'WA',
                'published' => true,
            ]);
            $statusesRepository->create([
                'title' => 'Оплачено',
                'code' => 'PA',
                'published' => true,
            ]);
            // $statusesRepository->create([
            //     'title' => 'Частично оплачено',
            //     'code' => 'PP',
            //     'published' => true,
            // ]);
            $statusesRepository->create([
                'title' => 'Возврат средств',
                'code' => 'RE',
                'published' => true,
            ]);
        }

        if (OrderStatus::count() == 0) {

            $orderStatusRepository = new OrderStatusRepository(new OrderStatus);

            $orderStatusRepository->create([
                'title' => 'Оформлен',
                'code' => 'DE',
                'published' => true,
            ]);
            $orderStatusRepository->create([
                'title' => 'Подтвержден',
                'code' => 'CO',
                'published' => true,
            ]);
            $orderStatusRepository->create([
                'title' => 'В работе',
                'code' => 'IW',
                'published' => true,
            ]);
            $orderStatusRepository->create([
                'title' => 'Выполнен',
                'code' => 'CM',
                'published' => true,
            ]);
            $orderStatusRepository->create([
                'title' => 'Отменён',
                'code' => 'AN',
                'published' => true,
            ]);

            $orderStatusRepository->create([
                'title' => 'Отменён пользователем',
                'code' => 'UN',
                'published' => true,
            ]);
        }

        if (DeliveryStatus::count() == 0) {

            $deliveryRepository = new DeliveryStatusRepository(new DeliveryStatus);

            $deliveryRepository->create([
                'title' => 'Передан курьеру',
                'code' => 'HC',
                'published' => true,
            ]);
            $deliveryRepository->create([
                'title' => 'Доставлен',
                'code' => 'DE',
                'published' => true,
            ]);
            $deliveryRepository->create([
                'title' => 'Не доставлен',
                'code' => 'UD',
                'published' => true,
            ]);
        }
    }
}
