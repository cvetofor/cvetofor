<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Models\Order;

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
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->user->notify(new OrderCreatedUserNotification($event->order));
    }
}
