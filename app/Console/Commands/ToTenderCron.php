<?php

namespace App\Console\Commands;

use App\Notifications\OrderMovedToTenderNotification;
use Illuminate\Console\Command;

class ToTenderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tender:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяет заказы, которые магазин не взял в работу более 15 минут';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = \App\Models\Order::where('parent_id', '<>', null)
            ->where('market_id', '<>', null)
            ->whereHas('orderStatus', function ($q) {
                return $q->where('code', \App\Models\OrderStatus::ISSUED);
            })
            // Можно не брать в работу до тех пор пока заказ не оплачен
            ->whereHas('paymentStatus', function ($q) {
                return $q->where('code', \App\Models\PaymentStatus::PAID);
            })
            ->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(15));

        $ordersToTender = $query->get();

        if ($ordersToTender->count() > 0) {
            $marketsId = $ordersToTender->pluck('market_id');

            $query->update(['market_id' => null]);

            foreach ($ordersToTender as $order) {

                $markets = \App\Models\Market::published()
                    ->where('city_id', $order->city_id)
                    ->whereNotIn('id', $marketsId);

                $marketEmails = array_filter($markets->pluck('email')->toArray());

                foreach ($marketEmails as $mail) {
                    \Notification::route('mail', $mail)
                        ->notify(new OrderMovedToTenderNotification($order));
                }
            }
        }

        return Command::SUCCESS;
    }
}
