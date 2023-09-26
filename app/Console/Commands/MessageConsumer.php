<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Domain\Customer\Actions\Registration\CreateCustomerAction;
use Illuminate\Console\Command;

final class MessageConsumer extends Command
{
    protected $signature = 'app:message-consumer';

    public function handle(): void
    {
        $rabbitMQService = new RabbitMQService;
        $rabbitMQService->consume(exchange: 'ssb_direct', type: 'direct', queue: 'ussd', routingKey: 'ssb_uss', callback: function ($message) {
            $headers = $message->get('application_headers')->getNativeData();

            // Check the actions and call the right class
            if (data_get(target: $headers, key: 'action') === 'CreateCustomerAction'){
                $register = CreateCustomerAction::execute(
                    json_decode(
                        json: $message->getBody(),
                        associative: true
                    )
                );
                if ($register) $message->ack();
            }
            elseif (data_get(target: $headers, key: 'action') === 'ActivateCustomerAction'){
                $register = ActivateCustomerAction::execute(
                    json_decode(
                        json: $message->getBody(),
                        associative: true
                    )
                );
                if ($register) $message->ack();
            }
        });
    }
}
