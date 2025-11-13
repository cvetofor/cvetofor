<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCanceledNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
            $group = \TwillAppSettings::getGroupDataForSectionAndName('public', 'public')->content;
            $phone = $group['phone'];
        } catch (\Exception $e) {
            $phone = '8 (3012) 50-22-20';
        }

        $order = $this->order;
        $deliveryPrice = 0.0;

        if ($order->parent_id != null) {
            //  Теории такого не должно случится, чтобы основной заказ был отменён

            $ch = $order->childs;
            foreach ($ch as $child) {
                $deliveryPrice += $child->delivery->price;
            }
        } else {
            $deliveryPrice += $order->delivery->price;
        }
try{
        return (new MailMessage)
            ->subject('Отмена заказа № '.$this->order->num_order.' с сайта Цветофор.рф')
            ->greeting('Здравствуйте!')
            ->line('Меня зовут Екатерина - менеджер по продаже цветов и букетов маркет-плейса Цветофор. ')
            ->line('Отвечаю за то, чтобы оформленный ранее Вами заказ № '.$this->order->num_order.' был отменен а деньги вернулись на ваш счет в срок, до 7 рабочих дней, но обычно все гораздо быстрее.')
            ->line('Давайте посмотрим, что Вы заказали ранее и сверим контактные данные:')

            ->with('Если все данные верны, вам нужно немного подождать возврат.')
            ->with('Если данные не верны или заказ отменен без вашего согласования, напишите нам или позвоните по телефону: '.$phone)
            ->salutation('Надеемся увидеть вас снова в нашем замечательном маркет-плейсе цветов “Цветофор”.')
            ->markdown('emails.user.order.changestatus', compact('order', 'deliveryPrice'));
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
