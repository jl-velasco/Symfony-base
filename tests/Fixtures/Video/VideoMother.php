<?php

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\Comments;
use Symfony\Base\Video\Domain\Video;

class VideoMother extends Mother
{

    private Uuid $id;
    private Uuid $userUuid;
    private Name $name;
    private Description $description;
    private Url $url;
    private Comments $comments;

    public static function create(): Mother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     */
    public function random(): self
    {
        $this->id = Uuid::random();
        $this->userUuid = Uuid::random();
        $this->name = new Name($this->faker->name());
        $this->description = new Description($this->faker->text());
        $this->url = new Url($this->faker->url());
        $this->comments = new Comments([]);
        return $this;
    }

    public function build(): Video
    {
        return new Video(
            $this->id,
            $this->userUuid,
            $this->name,
            $this->description,
            $this->url,
            null,
            null,
            $this->comments
        );
    }

    public function addComments(Comments $comments): self
    {
        foreach ($this->faker->randomNumber(1) as $comment) {
            $comments->add(CommentMother::create()->random()->build());
        }

        return $this;
    }

    public function withComments(): self
    {
        $this->comments = new Comments([]);
        return $this->addComments($this->comments);
    }
}