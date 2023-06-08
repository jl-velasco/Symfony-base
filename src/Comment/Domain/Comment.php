<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;

class Comment
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $videoId,
        private readonly Description $comment,
        private readonly CreatedAt $createdAt,
        private readonly UpdatedAt $updatedAt,
    )
    {
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function comment(): Description
    {
        return $this->comment;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return UpdatedAt
     */
    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @return Uuid
     */
    public function videoId(): Uuid
    {
        return $this->videoId;
    }


}
