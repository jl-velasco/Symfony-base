<?php

namespace Symfony\Base\Video\Like\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\EventBus;
use Symfony\Base\Video\Shared\Domain\LikeCreated;
use Symfony\Base\Video\Shared\Domain\VideoId;

class Like extends AggregateRoot
{
    public function __construct(
        private readonly LikeId     $id,
        private readonly VideoId    $videoId,
        private readonly LikeUserId $userId,
        private readonly CreatedAt  $createdAt
    )
    {
    }

    public static function create(
        string $likeId,
        string $videoId,
        string $userId
    ): Like
    {
        $like = new self(
            new LikeId($likeId),
            new VideoId($videoId),
            new LikeUserId($userId),
            new CreatedAt()
        );

        $like->record(
            new LikeCreated(
                $like->id()->value(),
                $like->videoId()->value(),
                $like->userId()->value()
            )
        );

        return $like;
    }

    public function id(): LikeId
    {
        return $this->id;
    }

    public function videoId(): VideoId
    {
        return $this->videoId;
    }

    public function userId(): LikeUserId
    {
        return $this->userId;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function save(LikeRepository $repository, EventBus $eventBus):void
    {
        $repository->save($this);
        $eventBus->publish(...$this->pullDomainEvents());
    }
}