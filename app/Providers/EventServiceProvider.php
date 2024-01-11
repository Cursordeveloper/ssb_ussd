<?php

declare(strict_types=1);

namespace App\Providers;

use Domain\NewCustomer\Events\Registration\CustomerCreatedEvent;
use Domain\NewCustomer\Listeners\Registration\CustomerCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        CustomerCreatedEvent::class => [
            CustomerCreatedListener::class,
        ],
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
