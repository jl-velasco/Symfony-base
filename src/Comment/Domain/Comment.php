<?php

namespace Symfony\Base\Comment\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class Comment
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $videoId,
        private readonly CommentMessage $message,
        private readonly Uuid $userId,
    ) {
    }

    public function equals(Comment $comment): bool
    {
        return $this->id()->equals($comment->id());
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    public function message(): CommentMessage
    {
        return $this->message;
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    /**
     * @param array<string, mixed> $comment
     * @throws InvalidValueException
     */
    public static function fromArray(array $comment): self
    {
        return new self(
            new Uuid($comment['id']),
            new Uuid($comment['video_id']),
            new CommentMessage($comment['message']),
            new Uuid($comment['user_id'])
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'video_id' => $this->videoId()->value(),
            'message' => $this->message()->value(),
            'user_id' => $this->userId()->value(),
        ];
    }
}