<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;

class VideoCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly string $userId,
        // estas variables/propiedades son para VideoProjection
        private readonly string $name,
        private readonly string $description,
        private readonly string $url,
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

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string
    {
        return $this->url;
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
            // son para videoprojection
            'name' => $this->name(),
            'description' => $this->description(),
            'url' => $this->url(),
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        ?string $eventId,
        ?string $occurredOn
    ): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['user_id'],
            // son para video proyection
            $body['name'],
            $body['description'],
            $body['url'],
            $eventId,
            $occurredOn);
    }
}