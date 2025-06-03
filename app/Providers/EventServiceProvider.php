<?php

namespace App\Providers;

use App\Events\OrderAmocrmUpdate;
use App\Events\OrderChangeStatus;
use App\Events\OrderCreated;
use App\Events\OrderDeliveryChanged;
use App\Events\OrderPaymentReceived;
use App\Listeners\OrderChangeStatusListener;
use App\Listeners\OrderCreatedCrmListener;
use App\Listeners\OrderCreatedListener;
use App\Listeners\OrderDeliveryChangedListener;
use App\Listeners\OrderPaymentReceivedListener;
use App\Listeners\OrderUpdatedCrmListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderChangeStatus::class => [
            OrderChangeStatusListener::class,
        ],
        OrderCreated::class => [
            OrderCreatedListener::class,
            OrderCreatedCrmListener::class,
        ],
        OrderDeliveryChanged::class => [
            OrderDeliveryChangedListener::class,
        ],
        OrderPaymentReceived::class => [
            OrderPaymentReceivedListener::class,
        ],
        OrderAmocrmUpdate::class => [
            OrderUpdatedCrmListener::class,
        ],
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
