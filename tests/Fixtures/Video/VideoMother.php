<?php

declare(strict_types=1);

namespace Symfony\Base\Tests\Fixtures\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Tests\Fixtures\Mother;
use Symfony\Base\Video\Domain\Comment;
use Symfony\Base\Video\Domain\CommentMessage;
use Symfony\Base\Video\Domain\Comments;
use Symfony\Base\Video\Domain\Video;

final class VideoMother extends Mother
{
    private Uuid $uuid;
    private Uuid $userUuid;
    private Name $name;
    private Description $description;
    private Url $url;
    private Date $createdAt;
    private Date $updatedAt;
    private ?Comments $comments;

    public static function create(): VideoMother
    {
        return new self();
    }

    /**
     * @throws InvalidValueException
     */
    public function random(): VideoMother
    {
        $this->uuid = Uuid::random();
        $this->userUuid = Uuid::random();
        $this->name = new Name(implode(' ', $this->faker->words(5)));
        $this->description = new Description($this->faker->sentence(5));
        $this->url = new Url($this->faker->url());
        $this->createdAt = new Date($this->faker->date());
        $this->updatedAt = new Date($this->faker->date());
        $this->comments = new Comments([]);

        return $this;
    }

    public function withUuid(Uuid $uuid): VideoMother
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function withUserUuid(Uuid $userUuid): VideoMother
    {
        $this->userUuid = $userUuid;
        return $this;
    }

    public function withName(Name $name): VideoMother
    {
        $this->name = $name;
        return $this;
    }

    public function withDescription(Description $description): VideoMother
    {
        $this->description = $description;
        return $this;
    }

    public function withUrl(Url $url): VideoMother
    {
        $this->url = $url;
        return $this;
    }

    public function withCreatedAt(Date $createdAt): VideoMother
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withUpdatedAt(Date $updatedAt): VideoMother
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function withComments(Comments $comments): VideoMother
    {
        $this->comments = $comments;
        return $this;
    }

    public function withRandomComments(): VideoMother
    {
        $this->comments = new Comments(iterator_to_array((function() {
            for ($i = 0; $i++; $i < $this->faker->numberBetween(1, 20)) {
                yield CommentMother::create()
                    ->random()
                    ->withVideoId($this->uuid)
                    ->build()
                ;
            }
        })()));
        return $this;
    }

    public function build(): Video
    {
        return new Video(
            $this->uuid,
            $this->userUuid,
            $this->name,
            $this->description,
            $this->url,
            $this->createdAt,
            $this->updatedAt,
            $this->comments
        );
    }
}