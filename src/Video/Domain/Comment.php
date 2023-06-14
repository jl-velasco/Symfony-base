<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class Comment
{
    public function __Construct(private readonly Uuid    $commentId,
                                private readonly Message $message)
    {

    }

    public function equals(Comment $commentId): bool
    {
        return $this->commentId->equals($this->commentId);
    }

    public function commentId(): Uuid
    {
        return $this->commentId;
    }

    public function message(): Message
    {
        return $this->message;
    }
    public function  videoId():Uuid
    {
    return $this->videoId();
    }

}
