<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;

final class MessageConsumer extends Command
{
    protected $signature = 'app:message-consumer';

    public function handle(): void
    {
        $rabbitMQService = new RabbitMQService;
        $rabbitMQService->consume(exchange: 'ssb_direct', type: 'direct', queue: 'web', routingKey: 'ssb_web', callback: function ($message) {

//            $headers = $message->has('application_headers') ? $message->get('application_headers')->getNativeData() : [];

            logger(message: $message->get('application_headers')->getNativeData());
            logger(message: json_decode($message->getBody(), associative: true));

            $message->ack();
        });
    }
}
