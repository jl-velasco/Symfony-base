<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Bus\Event\RabbitMQ;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Infrastructure\Bus\Event\DomainEventJsonSerializer;

final class RabbitMqEventBus //implements EventBus
{
    public function __construct(private readonly RabbitMqConnection $connection)
    {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->publishEvent($event);
        }
    }

    private function publishEvent(DomainEvent $event): void
    {
        $body = DomainEventJsonSerializer::serialize($event);
        $routingKey = $event->eventName();

        $this->connection->publish($body, $routingKey);
    }
}