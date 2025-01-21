<?php

namespace Symfony\Base\Video\Shared\Domain;

use Symfony\Base\Shared\Domain\DomainEvent;

class LikeCreated extends DomainEvent
{
    public function __construct(
        private readonly string $aggregateId,
        private readonly string $videoId,
        private readonly string $userId,
        string                  $eventId = null,
        string                  $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'like.created';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->aggregateId,
            'video_id' => $this->videoId,
            'user_id' => $this->userId,
        ];
    }

    public static function fromPrimitives(string $aggregateId, array $body, ?string $eventId, ?string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['video_id'],
            $body['user_id'],
            $eventId,
            $occurredOn
        );
    }
}