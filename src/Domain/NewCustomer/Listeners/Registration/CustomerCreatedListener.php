<?php

namespace Domain\NewCustomer\Listeners\Registration;

use App\Services\Customer\Requests\Customer\CustomerServiceCustomerCreateRequest;
use App\Services\Mobile\Requests\MobileServiceCustomerCreateRequest;
use Domain\NewCustomer\Data\Registration\CustomerData;
use Illuminate\Contracts\Queue\ShouldQueue;

final class CustomerCreatedListener implements ShouldQueue
{
    public function handle(object $event): void
    {
        // Define the message data
        $data = CustomerData::toArray(customer: $event->customer);

        // Publish message through http
        (new CustomerServiceCustomerCreateRequest)->execute(data: $data);
        (new MobileServiceCustomerCreateRequest)->execute(data: $data);
    }
}
