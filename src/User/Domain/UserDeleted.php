<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class UserDeleted extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private string $userId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'user.deleted';
    }

    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->userId,
        ];
    }
}