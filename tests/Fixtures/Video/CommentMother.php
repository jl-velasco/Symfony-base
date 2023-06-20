<?php

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\CommentMessage;

class CommentMother extends Mother
{
    private Uuid $id;
    private Uuid $videoId;
    private CommentMessage $message;

    public static function create(): Mother
    {
        return new self();
    }

    public function random(): self
    {
        $this->id = Uuid::random();
        $this->videoId = Uuid::random();
        $this->message = StringValueObject::random();
        return $this;
    }

    public function build(): CommentMessage
    {
        return new CommentMessage(
            $this->id,
            $this->videoId,
            $this->message
        );
    }

}