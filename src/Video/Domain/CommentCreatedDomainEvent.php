<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class CommentCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        private readonly Uuid $commentId,
        private readonly CommentMessage $message,
        private readonly Uuid $userId,
        ?string $eventId = null,
        ?string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public function commentId(): Uuid
    {
        return $this->commentId;
    }

    public function message(): CommentMessage
    {
        return $this->message;
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public static function eventName(): string
    {
        return 'hiberus.video.event.comment_created';
    }

    public function toPrimitives(): array
    {
        return [
            'comment_id' => $this->commentId()->value(),
            'message' => $this->message()->value(),
            'user_id' => $this->userId()->value()
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
            new Uuid($body['comment_id']),
            new CommentMessage($body['message']),
            new Uuid($body['user_id']),
            $eventId,
            $occurredOn);
    }
}