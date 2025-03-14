<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\DeliveryStatus;
use App\Models\Market;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Создания заявок для выплат магазинам
 */
class MarketplacePaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Market $market;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Market $market)
    {
        $this->market = $market;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->market->withdrawalFunds() > 0) {
            $market = $this->market->fresh();

            \DB::transaction(function () use ($market) {
                $cOrders = $market->getCompletedOrders()->pluck('id')?->toArray() ?? [];
                $rOrders = $market->getReturnedOrders()->pluck('id')?->toArray() ?? [];
                $orders = array_merge($cOrders, $rOrders);

                $balance = Balance::create([
                    'published'   => true,
                    'title'       => 'Перевод на р/с',
                    'total'       => $market->withdrawalFunds(),
                    'market_id'   => $market->id,
                    'status'      => Balance::STATUS['WAIT_APPROVE'],
                    'description' => '',
                ]);

                if ($orders) {
                    foreach ($orders as $order) {
                        $balance->orders()->attach($order, ['code' => Order::where('id', $order)->first()->orderStatus?->code]);
                    }
                }

                $balance->save();

            });
        }

    }



}
