<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
