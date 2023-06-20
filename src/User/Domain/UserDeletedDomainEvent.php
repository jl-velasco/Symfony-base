<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class UserDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'hiberus.user.event.user_deleted';
    }

    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->aggregateId(),
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $eventId, $occurredOn);
    }
}