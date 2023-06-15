<?php

declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoDeleted extends DomainEvent
{
    public function __construct(
        private readonly Uuid $videoId,
        private readonly Uuid $userId,
        ?Uuid $eventId = null,
        ?Date $occurredOn = null
    )
    {
        parent::__construct($videoId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'video.deleted';
    }

    public function toPrimitives(): array
    {
        return [
            'video_id' => $this->videoId->value(),
            'user_id' => $this->userId->value(),
        ];
    }
}