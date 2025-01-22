<?php

namespace Symfony\Base\Tweet\Like\Domain;

use Symfony\Base\Shared\Domain\DomainEvent;

class LikeCreated extends DomainEvent
{
    public function __construct(
        string                  $aggregateId,
        private readonly string $tweetId,
        private readonly string $userId,
        ?string                 $eventId = null,
        ?string                 $occurredOn = null
    )
    {
        parent::__construct(
            $aggregateId,
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'tweet.like_created';
    }

    public function toPrimitives(): array
    {
        return [
            'tweet_id' => $this->tweetId,
            'user_id' => $this->userId
        ];
    }

    public static function fromPrimitives(string $aggregateId, array $body, ?string $eventId, ?string $occurredOn): DomainEvent
    {
        return new self(
            $aggregateId,
            $body['tweet_id'],
            $body['user_id'],
            $eventId,
            $occurredOn
        );
    }
}