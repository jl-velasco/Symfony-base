<?php

namespace Symfony\Base\Tweet\Like\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Tweet\Shared\Domain\TweetId;

class Like extends AggregateRoot
{
    public function __construct(
        private readonly LikeId    $id,
        private readonly TweetId    $tweetId,
        private readonly LikeUserId $userId,
        private readonly CreatedAt  $createdAt
    )
    {
    }

    public static function create(
        string $likeId,
        string $tweetId,
        string $userId
    ): Like
    {
        $like = new self(
            new LikeId($likeId),
            new TweetId($tweetId),
            new LikeUserId($userId),
            new CreatedAt()
        );
        $like->record(
            new LikeCreated(
                $like->id()->value(),
                $like->tweetId()->value(),
                $like->userId()->value(),
                $like->createdAt()->stringDateTime()
            )
        );

        return $like;
    }

    public function id(): LikeId
    {
        return $this->id;
    }

    public function userId(): LikeUserId
    {
        return $this->userId;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function tweetId(): TweetId
    {
        return $this->tweetId;
    }
}