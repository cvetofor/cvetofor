<?php

namespace App\Notifications;

use A17\Twill\Facades\TwillAppSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompletedNotification extends Notification implements ShouldQueue
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
            $group = TwillAppSettings::getGroupDataForSectionAndName('public', 'public')->content;
            $phone = $group['phone'];
        } catch (\Exception $e) {
            $phone = 'номер телефона';
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
            ->subject('Заказ № '.$this->order->num_order.' с сайта Цветофор.рф выполнен!')
            ->greeting('Здравствуйте!')
            ->line('Ваш заказ № '.$this->order->num_order.' был успешно доставлен. ')

            ->with('Благодарим вас за выбор!')
            ->with('Надеемся, букет вам понравился и вы довольны сервисом.')
            ->with('Будет здорово, если вы поделитесь впечатлениями о букете и нашей работе на нашем сайте '.route('profile.orders').'')
            ->with('По всем вопросам вы можете звонить по телефону '.$phone.' или написать нам почту. ')
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
