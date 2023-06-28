<?php

namespace Symfony\Base\Video\Domain;

use Exception;
use Symfony\Base\Shared\Domain\AggregateRoot;
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
        Name $name
    ): self
    {

        $video = new self(
            $uuid,
            $userUuid,
            $name
        );

        $video->record(
            new VideoCreatedDomainEvent(
                $uuid->value(),
                $userUuid,
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

    public static function fromArray(array $video): self
    {
        return new self(
            new Uuid($video['uuid']),
            new Uuid($video['userUuid']),
            new Name($video['name'])
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid()->value(),
            'userUuid' => $this->userUuid()->value(),
            'name' => $this->name()->value()
        ];
    }
}