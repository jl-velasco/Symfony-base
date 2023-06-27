<?php

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentMessage;

class CommentMother extends Mother
{
    private Uuid $id;
    private Uuid $videoId;
    private CommentMessage $message;
    private Date $created_at;

    public static function create(): self
    {
        return new self();
    }

    public function random(): self
    {
        $this->id = Uuid::random();
        $this->videoId = Uuid::random();
        $this->message = new CommentMessage($this->faker->text());
        $this->created_at = new Date();
        return $this;
    }

    public function build(): Comment
    {
        return new Comment(
            $this->id,
            $this->videoId,
            $this->message,
            $this->created_at
        );
    }

    public function withId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withVideoId(Uuid $videoId): self
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function withMessage(CommentMessage $message): self
    {
        $this->message = $message;
        return $this;
    }
}
