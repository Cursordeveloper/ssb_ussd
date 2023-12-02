<?php

namespace Domain\Customer\Listeners;

use App\Services\RabbitMQService;
use Domain\Customer\DTO\CustomerDTO;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

final class CustomerCreatedListener implements ShouldQueue
{
    /**
     * @throws Exception
     */
    public function handle(object $event): void
    {
        // Define the message data
        $data = ['data' => CustomerDTO::toArray(customer: $event->customer)];

        // Define the message headers
        $headers = ['origin' => 'ussd', 'action' => 'CreateCustomerAction'];

        // Initialize the RabbitMQService and publish messages
        $rabbitMQService = new RabbitMQService;
        $rabbitMQService->publish(exchange: 'ssb_direct', routingKey: 'ssb_mob', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', routingKey: 'ssb_cus', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', routingKey: 'ssb_not', data: $data, headers: $headers);

        // Send http requests
        // TODO: Sent the data through HTTP to customer, mobile, and notification services
//        (new StoreCustomer)->execute($data);
    }
}
