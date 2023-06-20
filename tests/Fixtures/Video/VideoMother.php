<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\User\Domain\Password;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\VideoCounter;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentCounter;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Domain\Comments;
use Symfony\Base\Video\Domain\Video;

class VideoMother extends Mother
{
    private Uuid $id;
    private Uuid $userId;
    private Name $name;
    private Description $description;
    private Url $url;
    private CommentCounter $commentCounter;
    private Comments $comments;

    public static function create(): Mother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     * @throws \Symfony\Base\Shared\Domain\Exception\InvalidValueException
     */
    public function random(): self
    {
        $this->id = Uuid::random();
        $this->userId = Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description = new Description($this->faker->realText());
        $this->url = new Url($this->faker->url());
        $this->commentCounter = new CommentCounter(0);
        $this->comments = new Comments();

        return $this;
    }

    public function build(): Video
    {
        return new Video(
            $this->id,
            $this->userId,
            $this->name,
            $this->description,
            $this->url,
            new Date(),
            new Date(),
            $this->comments,
            $this->commentCounter
        );
    }

    public function withCommentCounter(CommentCounter $commentCounter): self
    {
        $this->commentCounter = $commentCounter;

        return $this;
    }

    /**
     * @throws InvalidValueException
     */
    public function addComment()
    {
        $this->comments->add(new Comment(
            Uuid::random(),
            Uuid::random(),
            new CommentMessage($this->faker->realText())));
        $this->commentCounter = $this->commentCounter->increment();
        return $this;
    }


}
