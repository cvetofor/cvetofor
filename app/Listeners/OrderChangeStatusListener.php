<?php

namespace App\Listeners;

use App\Models\Market;
use App\Models\OrderStatus;
use App\Events\OrderChangeStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderCanceledNotification;
use App\Notifications\OrderCompletedNotification;

class OrderChangeStatusListener
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
     * @param  \App\Events\OrderChangeStatus  $event
     * @return void
     */
    public function handle(OrderChangeStatus $event)
    {
        $notification = false;

        $order = \App\Models\Order::find($event->order->id);

        if (
            in_array($order->orderStatus->code, [
                OrderStatus::CANCELED,
                OrderStatus::CANCELED_USER,
            ])
        ) {
            $notification = new OrderCanceledNotification($order);
        } else if ($order->orderStatus->code == OrderStatus::COMPLETE) {
            $notification = new OrderCompletedNotification($order);
        }

        if ($notification) {
            $order->user->notify($notification);

            $managers = $order->load('market')->market?->employees()->where('send_notify_email', true)->whereHas('role', fn($q) => $q->where('code', 'manager'))->get();

            if ($managers) {
                \Notification::route('mail', $managers->pluck('email')?->toArray() ?? [])->notify($notification);
            }


        }
    }
}
