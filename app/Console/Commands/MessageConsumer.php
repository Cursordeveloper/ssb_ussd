<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Domain\NewCustomer\Actions\Registration\CustomerCreatedAction;
use Domain\NewCustomer\Actions\Registration\CustomerHasPinUpdateAction;
use Illuminate\Console\Command;

final class MessageConsumer extends Command
{
    protected $signature = 'app:message-consumer';

    public function handle(): void
    {
        $rabbitMQService = new RabbitMQService;
        $rabbitMQService->consume(queue: 'ussd', callback: function ($message) {
            // Get the message headers
            $headers = $message->get('application_headers')->getNativeData();

            // Define the action classes array
            $actionMappings = [
                'CustomerCreatedAction' => new CustomerCreatedAction,
                'PinCreatedAction' => new CustomerHasPinUpdateAction,
            ];

            // Get the action
            $actionKey = data_get(target: $headers, key: 'action');

            // Check if the action is mapped
            if (array_key_exists($actionKey, $actionMappings)) {
                $actionClass = $actionMappings[$actionKey];
                $register = $actionClass::execute(
                    json_decode(
                        json: $message->getBody(),
                        associative: true
                    )
                );

                if ($register) {
                    $message->ack();
                }
            }
        });
    }
}
