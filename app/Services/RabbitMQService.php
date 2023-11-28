<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

final class RabbitMQService
{
    protected AMQPStreamConnection $connection;
    protected AMQPChannel $channel;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('services.rabbitmq.host'),
            config('services.rabbitmq.port'),
            config('services.rabbitmq.username'),
            config('services.rabbitmq.password'),
            config('services.rabbitmq.vhost'),
        );
        $this->channel = $this->connection->channel();
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function publish(string $exchange, string $type, string $queue, string $routingKey, array $data, array $headers): void
    {
        $this->setupQueueAndExchange($exchange, $type, $queue, $routingKey);
        $message = new AMQPMessage(body: json_encode($data));

        $headers = new AMQPTable($headers);
        $message->set('application_headers', $headers);

        $this->channel->basic_publish(
            msg: $message,
            exchange: $exchange,
            routing_key: $routingKey
        );
    }

    public function consume(string $exchange, string $type, string $queue, string $routingKey, callable $callback): void
    {
        $this->setupQueueAndExchange($exchange, $type, $queue, $routingKey);

        $this->channel->basic_consume(
            queue: $queue,
            callback: $callback
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    private function setupQueueAndExchange(string $exchange, string $type, string $queue, string $routingKey): void
    {
        $this->channel->queue_declare(
            queue: $queue,
            durable: true,
            auto_delete: false
        );
        $this->channel->exchange_declare(
            exchange: $exchange,
            type: $type,
            durable: true,
            auto_delete: false
        );
        $this->channel->queue_bind(
            queue: $queue,
            exchange: $exchange,
            routing_key: $routingKey
        );
    }
}
