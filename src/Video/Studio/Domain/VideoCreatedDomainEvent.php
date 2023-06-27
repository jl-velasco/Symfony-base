<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Studio\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $userId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public static function eventName(): string
    {
        return 'hiberus.video.event.video_created';
    }

    /**
     * @return string[]
     */
    public function toPrimitives(): array
    {
        return [
            'user_id' => $this->userId(),
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent
    {
        return new self($aggregateId, $body['user_id'], $eventId, $occurredOn);
    }
}