<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentMessage;

class CommentMother extends Mother
{
    private Uuid $id;
    private Uuid $videoId;
    private CommentMessage $message;

    public static function create(): CommentMother
    {
        return new self();
    }

    public function random(): CommentMother
    {
        $this->id = Uuid::random();
        $this->videoId = Uuid::random();
        $this->message = new CommentMessage(implode(' ', $this->faker->words(5)));

        return $this;
    }

    public function build(): Comment
    {
        return new Comment(
            $this->id,
            $this->videoId,
            $this->message
        );
    }

    public function withId(Uuid $id): CommentMother
    {
        $this->id = $id;
        return $this;
    }

    public function withVideoId(Uuid $videoId): CommentMother
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function withMessage(CommentMessage $message): CommentMother
    {
        $this->message = $message;
        return $this;
    }
}