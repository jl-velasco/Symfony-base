<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Studio\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Comment
{

    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $videoId,
        private readonly CommentMessage $message,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null,
    ) {
    }

    public function equals(Comment $comment): bool
    {
        return $this->id()->equals($comment->id());
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    public function message(): CommentMessage
    {
        return $this->message;
    }

    public function createdAt(): ?Date
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt;
    }
}