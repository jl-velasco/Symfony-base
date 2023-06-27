<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class VideoCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly Uuid $userId,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function url(): Url
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
            'user_id' => $this->userId()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'url' => $this->url()->value()
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
            new Uuid($body['user_id']),
            new Name($body['user_id']),
            new Description($body['user_id']),
            new Url($body['user_id']),
            $eventId,
            $occurredOn);
    }
}