<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Events\OrderChangeStatus;
use App\Events\OrderDeliveryChanged;
use App\Events\OrderPaymentReceived;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\OrderCreatedListener;
use App\Listeners\OrderChangeStatusListener;
use App\Listeners\OrderDeliveryChangedListener;
use App\Listeners\OrderPaymentReceivedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class
        ],
        OrderChangeStatus::class => [
            OrderChangeStatusListener::class,
        ],
        OrderCreated::class => [
            OrderCreatedListener::class,
        ],
        OrderDeliveryChanged::class => [
            OrderDeliveryChangedListener::class,
        ],
        OrderPaymentReceived::class => [
            OrderPaymentReceivedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
