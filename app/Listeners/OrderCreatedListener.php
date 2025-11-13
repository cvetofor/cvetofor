<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\TelegramChatUser;
use App\Notifications\OrderCreatedMarketNotification;
use App\Notifications\OrderCreatedUserNotification;
use Notification;

class OrderCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->user->notify(new OrderCreatedUserNotification($event->order));

        $telegramBotApi = \Cache::remember(
            'telegramBotApi',
            360,
            function () {
                return \TwillAppSettings::getGroupDataForSectionAndName('resource', 'resource')->content['telegram_bot_api'];
            }
        );

        foreach ($event->order->childs as $_order) {
            // отправить на почту магазина
            $emails = [];
            $market_emails = $_order->market->email;

            $market_emails = trim($market_emails, '[]');
            $emails = array_map('trim', explode(',', $market_emails));

            foreach ($emails as $email) {
                try{
                    Notification::route('mail', $email)->notify(new OrderCreatedMarketNotification($_order));
                }catch (\Exception $e){

                }

            }

            try {
                if ($telegramBotApi && $_order->market->telegram_bot_market_username) {
                    $bot = @explode(':', $telegramBotApi)[0];

                    if ($bot) {
                        $chat_id = TelegramChatUser::where('username', str_replace('@', '', $_order->market->telegram_bot_market_username))
                            ->where('bot', $bot)->first();

                        if ($chat_id) {
                            $url = route('twill.orders.edit', ['order' => $_order->id]);
                            $message = "Заказ № {$_order->parent->id} \n\r[Перейти]({$url})";

                            $client = new \GuzzleHttp\Client;
                            $client->post(
                                "https://api.telegram.org/bot{$telegramBotApi}/sendMessage",
                                [
                                    \GuzzleHttp\RequestOptions::JSON => [
                                        'chat_id' => $chat_id->chat_id,
                                        'text' => $message,
                                        'parse_mode' => 'Markdown',
                                    ],
                                ]
                            );
                        }
                    }

                }
            } catch (\Throwable $th) {
                // throw $th;
            }

            try {
                Notification::route('mail', $_order->load('market')->market?->employees()->where('send_notify_email', true)->whereHas('role', fn ($q) => $q->where('code', 'manager'))->get())
                    ->notify(new OrderCreatedUserNotification($_order));
            } catch (\Throwable $th) {
                \Log::error($th->getMessage());
            }
        }
    }
}
