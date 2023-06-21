<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain\Events;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoDeletedEvent extends DomainEvent
{
    private const ROUTING_KEY = 'hiberus.video.event.video_deleted';

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
        return self::ROUTING_KEY;
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->userId,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, new Uuid($body['user_id']), $eventId, $occurredOn);
    }
}