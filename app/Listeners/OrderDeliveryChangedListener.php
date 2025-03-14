<?php

namespace App\Listeners;

use App\Events\OrderDeliveryChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderDeliveryChangedListener
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
     * @param  \App\Events\OrderDeliveryChanged  $event
     * @return void
     */
    public function handle(OrderDeliveryChanged $event)
    {
        //
    }
}
