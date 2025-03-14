<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $user;

    protected $email;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $email)
    {
        $this->user = $user;
        $this->email = $email;
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
        return (new MailMessage)
            ->greeting("Здравствуйте!")
            ->subject('Уведомление об изменении Email пользователя')
            ->line('Ссылка для изменения Email')
            ->action('Сменить Email', URL::temporarySignedRoute(
                'profile.changeEmail.confirm',
                now()->addMonth(1),
                ['user' => $this->user->id, 'email' => $this->email]
            ))
            ->line('Если вы не запрашивали изменение Email адреса, просто проигнорируйте данное сообщение');
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
        ];
    }
}
