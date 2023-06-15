<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoDeleted extends DomainEvent
{
    private const ROUTING_KEY = 'hiberus.video.event.video_deleted';

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
        return self::ROUTING_KEY;
    }

    public function toPrimitives(): array
    {
        return [
            'video_id' => $this->aggregateId(),
            'user_id' => $this->userId,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['user_id'], $eventId, $occurredOn);
    }
}
