<?php
declare(strict_types = 1);

namespace Symfony\Base\Registation\Domain\Exceptions;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class UserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private string $name,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'hiberus.user.event.user_created';
    }

    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->aggregateId(),
            'name' => $this->name,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['name'],$eventId, $occurredOn);
    }
}