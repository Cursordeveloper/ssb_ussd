<?php

namespace Domain\Customer\Listeners;

use App\Services\RabbitMQService;
use Domain\Customer\DTO\CustomerDTO;
use Illuminate\Contracts\Queue\ShouldQueue;

final class CustomerCreatedListener implements ShouldQueue
{
    public function handle(object $event): void
    {
        $headers = ['origin' => 'ussd', 'action' => 'CreateCustomerAction'];
        $data = ['data' =>  CustomerDTO::toArray($event->customer)];

        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publish(
            exchange: 'ssb_fanout',
            type: 'fanout',
            queue: 'ussd',
            routingKey: 'ssb_uss',
            data: $data,
            headers: $headers,
        );
    }
}
