<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\CreatedAt;
use Symfony\Base\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Domain\ValueObject\Description;

class Comment
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $videoId,
        private readonly Description $comment,
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
            'comment' => $this->comment()->value(),
            'created_at' => (string)$this->createdAt(),
            'updated_at' => (string)$this->updatedAt(),
        ];

        return $result;
    }

    /**
     * @throws InvalidValueException
     * @throws \Symfony\Base\Shared\Domain\Exception\InvalidValueException
     */
    static public function fromPrimitives($data): Comment
    {
        return new self(
            new Uuid($data['id']),
            new Uuid($data['video_id']),
            new Description($data['comment']),
            CreatedAt::fromPrimitive($data['created_at']),
            UpdatedAt::fromPrimitive($data['updated_at']),
        );
    }

}
