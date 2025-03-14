<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use A17\Twill\Facades\TwillAppSettings;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendPasswordAfterRegisterNotification extends Notification implements ShouldQueue
{
    use Queueable;


    protected string $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        $this->password = $password;
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
     * Determine which queues should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'mail-queue',
        ];
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

        return (new MailMessage)
            ->subject('Регистрация на сайте')
            ->greeting("Здравствуйте!")
            ->line('Вы были успешно зарегистрированы. ')
            ->line('Благодарим вас за выбор нашего маркет-плейса!')
            ->line('Надеемся, вам понравится работать с нами и вы будете довольны сервисом.')
            ->line('По всем вопросам вы можете звонить по телефону '.$phone.' или написать нам почту. ')
            ->line('Ваш пароль: ' . $this->password);
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
