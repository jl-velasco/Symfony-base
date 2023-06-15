<?php
declare(strict_types = 1);
namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoCreated extends DomainEvent
{

    public function __construct(
        string                  $aggregateId,
        private readonly string $videoId,
        ?string                 $eventId = null,
        ?string                 $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }


    public static function eventName(): string
    {
        return 'video.created';
    }

    public function toPrimitives(): array
    {
        return [
            'video_id' => $this->videoId,
        ];
    }
}
