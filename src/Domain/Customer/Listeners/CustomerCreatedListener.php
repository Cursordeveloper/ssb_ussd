<?php

namespace Domain\Customer\Listeners;

use App\Services\RabbitMQService;
use Domain\Customer\DTO\CustomerDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

final class CustomerCreatedListener implements ShouldQueue
{
    public function handle(object $event): void
    {
        // Prepare the message data
        $data = ['data' => CustomerDTO::toArray($event->customer)];

        // Dispatch the message ssb_customer service through http
//        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json',]
//        )->post(url: env(key: 'SSB_CUSTOMER'), data: $data);

        // Dispatch the message ssb_mobile service through http
        Http::withHeaders(['Content-Type' => 'application/vnd.api+json', 'Accept' => 'application/vnd.api+json']
        )->post(url: env(key: 'SSB_MOBILE').'registration/customer', data: $data);

        // Dispatch the message to the message broker (RabbitMQ)
        $headers = ['origin' => 'ussd', 'action' => 'CreateCustomerAction'];
//
        $rabbitMQService = new RabbitMQService();
//        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'mobile', routingKey: 'ssb_mob', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'customer', routingKey: 'ssb_cus', data: $data, headers: $headers);
        $rabbitMQService->publish(exchange: 'ssb_direct', type: 'direct', queue: 'notification', routingKey: 'ssb_not', data: $data, headers: $headers);
    }
}
