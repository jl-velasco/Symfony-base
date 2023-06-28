<?php

namespace Symfony\Base\Video\Domain;


use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Video extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userUuid,
        private readonly Name $name,

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
//
//    public function delete(): void
//    {
//        $this->record(
//            new VideoDeletedDomainEvent(
//                $this->uuid()->value(),
//                $this->userUuid(),
//            )
//        );
//    }
}
