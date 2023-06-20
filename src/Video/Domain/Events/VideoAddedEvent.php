<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain\Events;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoAddedEvent extends DomainEvent
{
    private const ROUTING_KEY = 'hiberus.video.event.video_added';

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

    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->userId->value(),
        ];
    }

    public function userId(): Uuid
    {
        return $this->userId;
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
        return new self($aggregateId, new Uuid($body['user_id']), $eventId, $occurredOn);
    }
}
