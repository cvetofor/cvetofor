<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedMarketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $phone = '';
        try {
            $group = \TwillAppSettings::getGroupDataForSectionAndName('public', 'public')->content;
            $phone = $group['phone'];
        } catch (\Exception $e) {
            $phone = 'номер телефона';
        }
        $this->order->load('delivery');

        $order = $this->order;
        $deliveryPrice = $this->order->delivery->price;

        \Log::channel('marketplace')->info('Отправлено письмо магазину о новом заказе №'.$this->order->num_order, ['deliveryPrice' => $deliveryPrice]);

        try {
            return (new MailMessage)
                ->subject('Новый заказ № ' . $this->order->num_order . ' с сайта Цветофор.рф')
                ->greeting('Здравствуйте Коллеги!')
                ->line('У нас оформленный новый заказ №' . $this->order->num_order . ' ')
                ->markdown('emails.market.order.created', compact('order', 'deliveryPrice'));
        }catch (\Exception $e){

        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
