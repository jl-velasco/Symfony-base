<?php

namespace Symfony\Base\Tweet\Tweet\Domain;

use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\UpdatedAt;
use Symfony\Base\Tweet\Shared\Domain\Content;
use Symfony\Base\Tweet\Shared\Domain\TweetId;
use Symfony\Base\Tweet\Shared\Domain\UserId;

class Tweet
{
    public function __construct(
        private readonly TweetId $id,
        private readonly UserId $userId,
        private TweetLikes $likes,
        private readonly Content $content,
        private readonly CreatedAt $createdAt,
        private readonly ?UpdatedAt $updatedAt,
    )
    {
    }

    public function id(): TweetId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function likes(): TweetLikes
    {
        return $this->likes;
    }

    public static function create(
        string $id,
        string $userId,
        string $content
    ): Tweet
    {
        return new self(
            new TweetId($id),
            new UserId($userId),
            TweetLikes::create(),
            new Content($content),
            new CreatedAt(),
            null
        );
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function save(TweetRepository $repository): void
    {
        $repository->save($this);
    }

    public function delete(TweetRepository $repository): void
    {
        $repository->delete($this->id());
    }

    public function addLike(): void
    {
        $this->likes = $this->likes->addLike();
    }
}