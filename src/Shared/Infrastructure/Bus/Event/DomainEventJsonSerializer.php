<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Bus\Event;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Utils;

final class DomainEventJsonSerializer
{
    public static function serialize(DomainEvent $domainEvent): string
    {
        return Utils::jsonEncode(
            [
                'data' => [
                    'id' => $domainEvent->eventId(),
                    'type' => $domainEvent::eventName(),
                    'occurred_on' => $domainEvent->occurredOn(),
                    'attributes' => array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->aggregateId()]),
                ],
                'meta' => [],
            ]
        );
    }
}