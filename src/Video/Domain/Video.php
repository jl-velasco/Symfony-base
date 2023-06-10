<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Video
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userUuid,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
    )
    {
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
}