<?php

namespace App\Notifications;

use A17\Twill\Facades\TwillAppSettings;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedUserNotification extends Notification implements ShouldQueue
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
        if (
            empty($notifiable->email) ||
            !filter_var($notifiable->email, FILTER_VALIDATE_EMAIL)
        ) {
            return []; // ⛔️ вообще ничего не отправляем
        }

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

        \Log::channel('marketplace')->info('Отправлено письмо покупателю о новом заказе №'.$this->order->num_order);
try{
        return (new MailMessage)
            ->subject('Новый заказ № '.$this->order->num_order.' с сайта Цветофор.рф')
            ->greeting('Здравствуйте!')
            ->line('Меня зовут Екатерина - менеджер по продаже цветов и букетов маркет-плейса “Цветофор”.')
            ->line('Отвечаю за то, чтобы оформленный Вами заказ №'.$this->order->num_order.' в целости и сохранности попал к вам в руки.')
            ->line('')
            ->line('Давайте посмотрим, что Вы заказали и сверим контактные данные: ')
            ->salutation('По всем вопросам вы можете звонить по телефону '.$phone.' или написать нам почту. ')
            ->markdown('emails.user.order.created', compact('order', 'deliveryPrice'));
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
