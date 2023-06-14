<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Password;
use function PHPUnit\Framework\equalTo;

final class Comment
{
    public function  __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $video_Uuid,
        private readonly Description $message,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
    )
    {

    }
    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function video_uuid(): Uuid
    {
        return $this->video_uuid;
    }

    public function descripcion(): Description
    {
        return $this->messaje;
    }

    public function createdAt(): ?Date
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt;
    }

    public function isEquals(Comment $comment): bool
    {
        return equalTo(md5($comment->uuid), $this->uuid());
    }

}