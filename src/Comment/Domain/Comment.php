<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Comment\Domain\Events\CommentAddedEvent;
use Symfony\Base\Comment\Domain\Events\CommentDeletedEvent;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\CreatedAt;
use Symfony\Base\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Domain\ValueObject\Description;

class Comment extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private Uuid $videoId,
        private Description $comment,
        private readonly CreatedAt $createdAt,
        private readonly UpdatedAt $updatedAt,
    )
    {
    }

    /**
     * @return Uuid
     */
    public function id(): Uuid
    {
        return $this->id;
    }

    public function comment(): Description
    {
        return $this->comment;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return UpdatedAt
     */
    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @return Uuid
     */
    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    public function toPrimitives(): array
    {
        $result = [
            'id' => $this->id()->value(),
            'video_id' => $this->videoId()->value(),
            'message' => $this->comment()->value(),
            'created_at' => (string)$this->createdAt(),
            'updated_at' => (string)$this->updatedAt(),
        ];

        return $result;
    }

    /**
     * @throws InvalidValueException
     * @throws \Symfony\Base\Shared\Domain\Exceptions\InvalidValueException
     */
    static public function fromPrimitives($data): Comment
    {
        return new self(
            new Uuid($data['id']),
            new Uuid($data['video_id']),
            new Description($data['message']),
            CreatedAt::fromPrimitive($data['created_at']),
            UpdatedAt::fromPrimitive($data['updated_at']),
        );
    }

    /**
     * @param Uuid $videoId
     */
    public function setVideoId(Uuid $videoId): void
    {
        $this->videoId = $videoId;
    }

    /**
     * @param Description $comment
     */
    public function setComment(Description $comment): void
    {
        $this->comment = $comment;
    }



    public function add(): void
    {
        $this->record(
            new CommentAddedEvent(
                $this->id()->value(),
                $this->videoId(),
            )
        );
    }

    public function delete(): void
    {
        $this->record(
            new CommentDeletedEvent(
                $this->id()->value(),
                $this->videoId(),
            )
        );
    }

}
