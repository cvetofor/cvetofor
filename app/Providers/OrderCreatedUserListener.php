<?php

namespace App\Providers;

use App\Models\Order;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderCreatedUserNotification;

class OrderCreatedUserListener
{

    public $order;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->user->notify(new OrderCreatedUserNotification($event->order));
    }
}
