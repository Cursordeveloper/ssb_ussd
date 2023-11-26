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
        // Prepare the message data
        $data = ['data' => CustomerDTO::toArray($event->customer)];

        // Dispatch the message to the message broker (RabbitMQ)
        $headers = ['origin' => 'ussd', 'action' => 'CreateCustomerAction'];

        $rabbitMQService = RabbitMQService::create();
        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'mobile', routingKey: 'ssb_mob', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'customer', routingKey: 'ssb_cus', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'notification', routingKey: 'ssb_not', data: $data, headers: $headers);
    }
}
