<?php

namespace App\Notifications;

use A17\Twill\Facades\TwillAppSettings;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaymentReceivedNotification extends Notification implements ShouldQueue
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
            ->subject('Заказ № '.$this->order->num_order.' с сайта Цветофор.рф оплачен!')
            ->greeting('Здравствуйте!')
            ->line('Ваш заказ №'.$this->order->num_order.' оплачен')
            ->salutation('По всем вопросам вы можете звонить по телефону '.$phone.' или написать нам почту. ')
            ->markdown('emails.user.order.received', compact('order', 'deliveryPrice'));
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
