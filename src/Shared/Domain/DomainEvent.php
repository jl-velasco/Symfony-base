<?php

namespace Symfony\Base\Shared\Domain;

abstract class DomainEvent
{
    public function __construct(
        private readonly string $aggregateId,
        private string $eventId,
        private string $occurredOn
    )
    {
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: (new Date())->stringDateTime();
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): self;
}