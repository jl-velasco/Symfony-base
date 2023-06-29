<?php

namespace Symfony\Base\Video\Domain;

use Exception;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\VideoCounter;

final class Video extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userUuid,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null,
        private readonly ?Comments $comments = new Comments([])
    ) {
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function userUuid(): Uuid
    {
        return $this->userUuid;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function createdAt(): ?Date
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt;
    }

    public function comments(): Comments
    {
        return $this->comments;
    }

    public function addComment(Uuid $id, CommentMessage $message): void
    {
        $this->comments->add(
            new Comment($id, $this->uuid(), $message)
        );
    }

    public function newComments(Video $video): Comments
    {
        return $video->comments()->diff($this->comments());
    }

    public static function create(
        Uuid $uuid,
        Uuid $userUuid,
        Name $name,
        Description $description,
        Url $url,
    ): self
    {

        $video = new self(
            $uuid,
            $userUuid,
            $name,
            $description,
            $url,
        );

        $video->record(
            new VideoCreatedDomainEvent(
                $uuid->value(),
                $userUuid->value(),
                $name->value(),
                $description->value(),
                $url->value()
            )
        );

        return $video;
    }

    public function delete(): void
    {
        $this->record(
            new VideoDeletedDomainEvent(
                $this->uuid()->value(),
                $this->userUuid(),
            )
        );
    }

    /**
     * @param array<string, mixed> $video
     * @throws InvalidValueException
     */
    public static function fromArray(array $video): self
    {
        return new self(
            new Uuid($video['id']),
            new Uuid($video['user_id']),
            new Name($video['name']),
            new Description($video['description']),
            new URL($video['url']),

        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->uuid()->value(),
            'user_id' => $this->userUuid()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'url' => $this->url()->value(),
        ];
    }
}