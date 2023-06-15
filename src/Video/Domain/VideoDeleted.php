<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoDeleted extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private string $videoId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        // TODO: Implement eventName() method.
        return 'user.deleted';
    }

    public function toPrimitives(): array
    {
        // TODO: Implement toPrimitives() method.
        return [
            'video_id' => $this->videoId,
        ];
    }
}