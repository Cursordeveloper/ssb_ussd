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
            config(key: 'services.rabbitmq.host'),
            config(key: 'services.rabbitmq.port'),
            config(key: 'services.rabbitmq.username'),
            config(key: 'services.rabbitmq.password'),
            config(key: 'services.rabbitmq.vhost'),
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

    public function publish(string $exchange, string $routingKey, array $data, array $headers): void
    {
        $message = new AMQPMessage(body: json_encode($data));

        $headers = new AMQPTable($headers);
        $message->set('application_headers', $headers);

        $this->channel->basic_publish(msg: $message, exchange: $exchange, routing_key: $routingKey);
    }

    public function consume(string $exchange, string $type, string $queue, string $routingKey, callable $callback): void
    {
        $this->channel->basic_consume(queue: $queue, callback: $callback);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
