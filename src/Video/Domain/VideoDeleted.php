<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

abstract class VideoDeleted extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly Uuid $userId,
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
        // TODO: Implement toPrimitives() method.
        return [
            'user_id' => $this->aggregateId(),
            'video_id' => $this->aggregateId()

        ];
    }
}