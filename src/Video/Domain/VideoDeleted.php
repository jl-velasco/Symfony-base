<?php
declare(strict_types = 1);
namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoDeleted extends DomainEvent
{
public function __construct(string $aggregateId,
                            private readonly  Uuid $userId,
                            private readonly Uuid $videoId,
                            ?Uuid $eventId = null,
                            ?Date $occurredOn = null)
{

    parent::__construct($aggregateId, $eventId, $occurredOn);
}

public static function eventName(): string{
    return 'video.deleted';
}
    public function toPrimitives(): array
    {
        return [
            'video_id' => $this->videoId,
            'user_id'=> $this->userId
        ];
    }

}
