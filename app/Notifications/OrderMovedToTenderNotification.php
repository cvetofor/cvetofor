<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use A17\Twill\Facades\TwillAppSettings;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderMovedToTenderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Undocumented variable
     *
     * @var [\App\Models\Order]
     */
    public $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
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
            $group = TwillAppSettings::getGroupDataForSectionAndName('public', 'public')->content;
            $phone = $group['phone'];
        } catch (\Exception $e) {
            $phone = 'номер телефона';
        }

        $order = $this->order;
        $ch = $order->childs;
        $deliveryPrice = 0.0;

        foreach ($ch as $child) {
            $deliveryPrice += $child->delivery->price;
        }

        return (new MailMessage)

            ->subject('Новый заказ № ' . $this->order->num_order . ' в Тендеры Цветофор.рф')
            ->greeting("Здравствуйте Коллеги!")
            ->line('У нас освободился новый заказ № ' . $this->order->num_order . '')
            ->line('Давайте посмотрим, что заказали и контактные данные: ')
            ->markdown('emails.market.order.tender', compact('order', 'deliveryPrice'));
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
