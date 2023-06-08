<?php

namespace Symfony\Base\Video\Domain;

use Composer\Util\Url;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;

class Video
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userId,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        private readonly CreatedAt $createdAt,
        private readonly UpdatedAt $updatedAt,
    )
    {
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Description
     */
    public function description(): Description
    {
        return $this->description;
    }

    /**
     * @return Url
     */
    public function url(): Url
    {
        return $this->url;
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
    public function userId(): Uuid
    {
        return $this->userId;
    }


}
