<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class InsertCommentCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $videoId,
        private readonly string $message,
        private readonly string $userId
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function videoId(): string
    {
        return $this->videoId;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function userId(): string
    {
        return $this->userId;
    }

}