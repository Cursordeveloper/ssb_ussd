<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Domain\Customer\Actions\Pin\PinCreatedAction;
use Domain\Customer\Actions\Registration\CreateCustomerAction;
use Illuminate\Console\Command;

final class MessageConsumer extends Command
{
    protected $signature = 'app:message-consumer';

    public function handle(): void
    {
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->consume(exchange: 'ssb_direct', type: 'direct', queue: 'ussd', routingKey: 'ssb_uss', callback: function ($message) {

            // Get the message headers
            $headers = $message->get('application_headers')->getNativeData();

            // Define the action classes array
            $actionMappings = [
                'CreateCustomerAction' => new CreateCustomerAction(),
                'PinCreatedAction' => new PinCreatedAction(),
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
