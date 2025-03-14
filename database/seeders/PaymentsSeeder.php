<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use App\Repositories\PaymentRepository;

class PaymentsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (Payment::count() == 0) {

            $paymentRepository = new PaymentRepository(new Payment);

            $paymentRepository->create([
                'name' => 'Наличный расчёт',
                'code' => 'cash',
                'position' => 1,
                'published' => true,
            ]);
            $paymentRepository->create([
                'name' => 'SberPay',
                'code' => 'sberpay',
                'position' => 2,
                'published' => true,
            ]);
            $paymentRepository->create([
                'name' => 'Robokassa',
                'code' => 'robokassa',
                'position' => 3,
                'published' => true,
            ]);
        }
    }
}
