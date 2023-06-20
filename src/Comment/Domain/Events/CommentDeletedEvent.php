<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Domain\Events;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class CommentDeletedEvent extends DomainEvent
{
    private const ROUTING_KEY = 'hiberus.comment.event.comment_deleted';

    public function __construct(
        string $aggregateId,
        private readonly Uuid $videoId,
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
            'video_id' => $this->videoId->value(),
        ];
    }

    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    /**
     * @throws InvalidValueException
     */
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, new Uuid($body['video_id']), $eventId, $occurredOn);
    }
}
