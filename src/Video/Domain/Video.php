<?php

namespace Symfony\Base\Video\Domain;

use Exception;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Events\VideoAddedEvent;
use Symfony\Base\Video\Domain\Events\VideoDeletedEvent;

class Video extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userUuid,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null,
        private ?Comments $comments = new Comments([]),
        private ?CommentCounter $commentCounter = new CommentCounter(0),
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
        $this->commentCounter = $this->commentCounter->increment();
        return $this;
    }

    public function deleteComment(): void
    {
        $this->commentCounter = $this->commentCounter->decrement();
    }

    /**
     * @throws Exception
     */
    public function newComments(Video $video): Comments
    {
        return $video->comments()->diff($this->comments());
    }

    public function commentCounter(): CommentCounter
    {
        return $this->commentCounter;
    }


    public function add()
    {
        $this->record(
            new VideoAddedEvent(
                $this->uuid()->value(),
                $this->userUuid(),
            )
        );
    }

    public function delete()
    {
        $this->record(
            new VideoDeletedEvent(
                $this->uuid()->value(),
                $this->userUuid(),
            )
        );
    }
}
