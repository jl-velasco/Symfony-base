<?php

namespace Symfony\Base\Video\Domain;

use Exception;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

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
        private ?Comments $comments = new Comments([])
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
        if (!$this->comments) {
            $this->comments = new Comments([]);
        }

        return $this->comments;
    }

    public function addComment(Uuid $id, CommentMessage $message): self
    {
        $this->comments->add(new Comment($id, $this->uuid(), $message));
        return $this;
    }

    /**
     * @throws Exception
     */
    public function newComments(Video $video): Comments
    {
        return $video->comments()->diff($this->comments());
    }

    public function isNew(): bool
    {
        return $this->updatedAt() === null;
    }

    public function add(): void
    {
        $this->record(new VideoAdded(
            $this->uuid(),
            $this->userUuid()
        ));
    }

    public function delete(): void
    {
        $this->record(new VideoDeleted(
            $this->uuid(),
            $this->userUuid()
        ));
    }
}