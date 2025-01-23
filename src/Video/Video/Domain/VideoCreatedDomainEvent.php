<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\DomainEvent;

class VideoCreatedDomainEvent extends DomainEvent
{
    public static function eventName(): string
    {
        // TODO: Implement eventName() method.
    }

    public function toPrimitives(): array
    {
        // TODO: Implement toPrimitives() method.
    }

    public static function fromPrimitives(string $aggregateId, array $body, ?string $eventId, ?string $occurredOn): DomainEvent
    {
        // TODO: Implement fromPrimitives() method.
    }
}