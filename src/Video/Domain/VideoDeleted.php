<?php
declare(strict_types = 1);
namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoDeleted extends DomainEvent
{
public function __construct(string $aggregateId,
                            private readonly string $videoId,
                            ?string $eventId = null,
                            ?string $occurredOn = null)
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
        ];
    }

}
