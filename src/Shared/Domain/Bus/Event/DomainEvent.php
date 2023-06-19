<?php
declare(strict_types = 1);

namespace Symfony\Base\Shared\Domain\Bus\Event;

use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;



abstract class DomainEvent
{

    public function __construct(
        private readonly string $aggregateId,
        private ?string $eventId = null,
        private ?string $occurredOn = null,
    ) {
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



}

