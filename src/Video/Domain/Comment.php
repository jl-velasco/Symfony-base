<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Message;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Comment
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $videoId,
        private readonly Message $message,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
    ) {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    public function message(): Message
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