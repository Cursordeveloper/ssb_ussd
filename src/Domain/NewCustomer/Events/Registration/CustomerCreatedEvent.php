<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Events\Registration;

use Domain\Shared\Models\Customer\Customer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class CustomerCreatedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public Customer $customer)
    {
    }
}
