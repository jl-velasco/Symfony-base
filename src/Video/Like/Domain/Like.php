<?php

namespace Symfony\Base\Video\Like\Domain;

use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Video\Shared\Domain\VideoId;

class Like
{
    public function __construct(
        private readonly LikeId    $id,
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
        return new self(
            new LikeId($likeId),
            new VideoId($videoId),
            new LikeUserId($userId),
            new CreatedAt()
        );
    }

    public function id(): VideoId
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
}