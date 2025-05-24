<?php

namespace App\Listeners;

use App\Events\OrderPaymentReceived;
use App\Notifications\OrderPaymentReceivedNotification;

class OrderPaymentReceivedListener
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
     * @param  \App\Providers\OrderPaymentReceived  $event
     * @return void
     */
    public function handle(OrderPaymentReceived $event)
    {
        $event->order->user->notify(new OrderPaymentReceivedNotification($event->order));
        $event->order->load('market')->market?->employees()->where('send_notify_email', true)->whereHas('role', fn ($q) => $q->where('code', 'manager'))->get()?->notify(new OrderPaymentReceivedNotification($event->order));
    }
}
